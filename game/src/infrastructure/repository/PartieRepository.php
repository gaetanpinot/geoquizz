<?php

namespace Geoquizz\Game\infrastructure\repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Geoquizz\Game\infrastructure\entities\Partie;
use Geoquizz\Game\infrastructure\interfaces\PartieInfraInterface;

/**
 * @extends ServiceEntityRepository<Partie>
 */
class PartieRepository extends EntityRepository implements PartieInfraInterface
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Partie::class));
    }

    public function getAllParties(): array
    {
        return $this->findAll();
    }
    public function getPartieById(int $id): Partie
    {
        return $this->find($id);
    }
    public function createPartie(Partie $partie): void
    {
        $em = $this->getEntityManager();
        $em->persist($partie);
        $em->flush();
    }

    //    /**
    //     * @return Partie[] Returns an array of Partie objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Partie
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}