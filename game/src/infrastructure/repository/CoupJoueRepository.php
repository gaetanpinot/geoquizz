<?php

namespace Geoquizz\Game\infrastructure\repository;

use Doctrine\ORM\EntityRepository;
use Geoquizz\Game\core\dto\JouerCoupDTO;
use Geoquizz\Game\infrastructure\entities\CoupJoue;
use Geoquizz\Game\infrastructure\entities\Partie;
use Geoquizz\Game\infrastructure\exceptions\InfraPartieTermineException;
use Geoquizz\Game\infrastructure\interfaces\CoupJoueRepositoryInterface;
use Geoquizz\Game\infrastructure\interfaces\PartieInfraInterface;

/**
 * @extends ServiceEntityRepository<CoupJoue>
 */
class CoupJoueRepository extends EntityRepository implements CoupJoueRepositoryInterface
{
    protected PartieInfraInterface $partieRepository;


    public function setPartieInfra(PartieInfraInterface $partieRepository): void
    {
        $this->partieRepository = $partieRepository;
    }

    public function coupsInit(int $idPartie, array $idsPoints): void
    {
        //create 10 coupjoue with idpartie + random image from serie(idserie)
        $em = $this->getEntityManager();
        $partie = $this->partieRepository->find($idPartie);
        shuffle($idsPoints);
        $points = array_slice($idsPoints, 0, 10);
        foreach ($points as $point) {
            $coupJoue = new CoupJoue();
            $coupJoue->setPartie($partie);
            $coupJoue->setIdPoint($point);
            $em->persist($coupJoue);
        }

        $em->flush();
    }

    public function joueCoup(JouerCoupDTO $jCoup)
    {
        $coupJoue = $this->getCoupByIdPartie($jCoup->getIdPartie());

        if($coupJoue == null) {
            throw new InfraPartieTermineException("Partie terminée");
        }
        $coupJoue->setLat($jCoup->getLat());
        $coupJoue->setLong($jCoup->getLon());
        $this->getEntityManager()->flush();
        return $coupJoue;
    }
    public function prochainCoup(int $idPartie)
    {
        $coupJoue = $this->getCoupByIdPartie($idPartie);
        if($coupJoue == null) {
            throw new InfraPartieTermineException("Partie terminée");
        }
        return $coupJoue;
    }
    public function calculerNbCoupsRestant(int $idPartie): int
    {
        $coups = $this->getEntityManager()->getRepository(CoupJoue::class)->findBy(['partie' => $idPartie, 'lat' => null]);
        return count($coups);
    }

    public function getAllCoupsFromPartie($idPartie)
    {
        $em = $this->getEntityManager();
        $coups = $em->getRepository(CoupJoue::class)->findBy(['partie' => $idPartie]);

        return $coups;
    }

    public function modifCoupDateJoue(int $idPartie): void
    {
        $coup = $this->getCoupByIdPartie($idPartie);
        if($coup->getDateJoue() != null) {
            return;
        }

        $dateTime = new \DateTime();
        $coup->setDateJoue($dateTime);
        $this->getEntityManager()->flush();
    }

    private function getCoupByIdPartie(int $idPartie): ?object
    {
        return $coupJoue = $this->
            getEntityManager()->
            getRepository(CoupJoue::class)->
            findOneBy(['partie' => $idPartie,
            'lat' => null], ['id' => 'ASC']);
    }
}
