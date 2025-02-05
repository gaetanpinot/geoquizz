<?php

namespace Geoquizz\Game\infrastructure\repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Geoquizz\Game\core\dto\CommencerJeuDTO;
use Geoquizz\Game\core\dto\CoupNextResponseDTO;
use Geoquizz\Game\core\dto\CoupConfirmeResponseDTO;
use Geoquizz\Game\core\dto\JouerCoupDTO;
use Geoquizz\Game\infrastructure\entities\CoupJoue;
use Geoquizz\Game\infrastructure\entities\Partie;
use Geoquizz\Game\infrastructure\entities\Serie;
use Geoquizz\Game\infrastructure\interfaces\CoupJoueRepositoryInterface;




/**
 * @extends ServiceEntityRepository<CoupJoue>
 */
class CoupJoueRepository extends EntityRepository implements CoupJoueRepositoryInterface
{
    public function coupsInit(int $idPartie, array $idsPoints): void{
        //create 10 coupjoue with idpartie + random image from serie(idserie)
        $em = $this->getEntityManager();
        $partie = $em->getRepository(Partie::class)->find($idPartie);
        shuffle($idsPoints);
        $points = array_slice($idsPoints, 0, 10);
        foreach ($points as $point){
            $coupJoue = new CoupJoue();
            $coupJoue->setPartie($partie);
            $coupJoue->setIdPoint($point);
            $em->persist($coupJoue);
        }

        $em->flush();
    }


    public function commencerPartie(CommencerJeuDTO $commencerJeuDTO): CoupNextResponseDTO{
        $em = $this->getEntityManager();

        //sort all coups by id, get the first one (findOne) with lat = null
        $coupJoue = $em->getRepository(CoupJoue::class)->findOneBy(['partie' => $commencerJeuDTO->getIdPartie(), 'lat' => null], ['id' => 'ASC']);
        if($coupJoue == null){
            throw new \Exception("Partie terminée");
        }
        $em->flush();
        return new CoupNextResponseDTO($coupJoue->getId(), $coupJoue->getIdPoint());
    }

    public function joueCoup(JouerCoupDTO $jCoup): CoupConfirmeResponseDTO
    {
        $em = $this->getEntityManager();
        $coupJoue = $em->getRepository(CoupJoue::class)->find($jCoup->getIdCoup());
        if($coupJoue == null){
            throw new \Exception("Coup inexistant");
        }
        $coupJoue->setLat($jCoup->getLat());
        $coupJoue->setLong($jCoup->getLon());
        $em->flush();
        return new CoupConfirmeResponseDTO($coupJoue->getId(), $coupJoue->getLat(), $coupJoue->getLong(), $coupJoue->getScore());
    }

    public function prochainCoup(string $idPartie){
        $em = $this->getEntityManager();
        $coupJoue = $em->getRepository(CoupJoue::class)->findOneBy(['partie' => $idPartie, 'lat' => null], ['id' => 'ASC']);
        if($coupJoue == null){
            throw new \Exception("Partie terminée");
        }
        return new CoupNextResponseDTO($coupJoue->getId(), $coupJoue->getIdImage());

    }

    public function getAllCoupsFromPartie($idPartie){
        $em = $this->getEntityManager();
        $coups = $em->getRepository(CoupJoue::class)->findBy(['partie' => $idPartie]);
        //return array of CoupsJoue
        return $coups;
    }


    //    /**
    //     * @return CoupJoue[] Returns an array of CoupJoue objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CoupJoue
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}