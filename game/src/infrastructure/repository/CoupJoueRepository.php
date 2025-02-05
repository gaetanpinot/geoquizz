<?php

namespace Geoquizz\Game\infrastructure\repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Geoquizz\Game\core\dto\CommencerJeuDTO;
use Geoquizz\Game\core\dto\CoupResponseDTO;
use Geoquizz\Game\infrastructure\entities\CoupJoue;
use Geoquizz\Game\infrastructure\entities\Partie;
use Geoquizz\Game\infrastructure\interfaces\CoupJoueRepositoryInterface;

/**
 * @extends ServiceEntityRepository<CoupJoue>
 */
class CoupJoueRepository extends EntityRepository implements CoupJoueRepositoryInterface
{
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, CoupJoue::class);
//    }

    public function coupsInit(){
        //create 10 void coupjoue with idpartie


    }


    public function commencerPartie(CommencerJeuDTO $commencerJeuDTO): CoupResponseDTO{
        //create 10 void coupjoue with idpartie
        //return score (0)  image

        $em = $this->getEntityManager();
        $partie = $em->getRepository(Partie::class)->find($commencerJeuDTO->getIdPartie());




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