<?php

namespace Geoquizz\Game\infrastructure\repository;

use Doctrine\ORM\EntityRepository;
use Geoquizz\Game\core\dto\CommencerJeuDTO;
use Geoquizz\Game\core\dto\CoupNextResponseDTO;
use Geoquizz\Game\core\dto\CoupConfirmeResponseDTO;
use Geoquizz\Game\core\dto\JouerCoupDTO;
use Geoquizz\Game\infrastructure\entities\CoupJoue;
use Geoquizz\Game\infrastructure\entities\Partie;
use Geoquizz\Game\infrastructure\interfaces\CoupJoueRepositoryInterface;

/**
 * @extends ServiceEntityRepository<CoupJoue>
 */
class CoupJoueRepository extends EntityRepository implements CoupJoueRepositoryInterface
{
    public function coupsInit(int $idPartie, array $idsPoints): void
    {
        //create 10 coupjoue with idpartie + random image from serie(idserie)
        $em = $this->getEntityManager();
        $partie = $em->getRepository(Partie::class)->find($idPartie);
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

//    public function commencerPartie(CommencerJeuDTO $commencerJeuDTO): CoupNextResponseDTO{
//        $em = $this->getEntityManager();
//
//        //sort all coups by id, get the first one (findOne) with lat = null
//        $coupJoue = $em->getRepository(CoupJoue::class)->findOneBy(['partie' => $commencerJeuDTO->getIdPartie(), 'lat' => null], ['id' => 'ASC']);
//        if($coupJoue == null){
//            throw new \Exception("Partie terminée");
//        }
////        $em->flush();
//        return new CoupNextResponseDTO($coupJoue->getId(), $coupJoue->getIdPoint());
//    }

    public function joueCoup(JouerCoupDTO $jCoup)
    {

        $coupJoue = $this->getCoupByIdPartie($jCoup->getIdPartie());

        if($coupJoue == null){
            throw new \Exception("Partie terminée");
        }
        $coupJoue->setLat($jCoup->getLat());
        $coupJoue->setLong($jCoup->getLon());
        $this->getEntityManager()->flush();
        return $coupJoue;
    }

    public function prochainCoup(string $idPartie){
        $coupJoue = $this->getCoupByIdPartie($idPartie);
        if($coupJoue == null){
            throw new \Exception("Partie terminée");
        }
        return $coupJoue;
    }

    public function getAllCoupsFromPartie($idPartie){
        $em = $this->getEntityManager();
        $coups = $em->getRepository(CoupJoue::class)->findBy(['partie' => $idPartie]);
        //return array of CoupsJoue
        return $coups;
    }

    private function getCoupByIdPartie($idPartie) : object
    {
        return $coupJoue = $this->getEntityManager()->getRepository(CoupJoue::class)->findOneBy(['partie' => $idPartie, 'lat' => null], ['id' => 'ASC']);
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