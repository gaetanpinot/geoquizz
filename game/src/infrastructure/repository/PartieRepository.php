<?php

namespace Geoquizz\Game\infrastructure\repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Geoquizz\Game\core\dto\NewPartieDTO;
use Geoquizz\Game\infrastructure\entities\Partie;
use Geoquizz\Game\infrastructure\interfaces\InfraEntityNotFoundException;
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
        $partie = $this->find($id);
        if ($partie == null) {
            throw new InfraEntityNotFoundException("Partie not found");
        }
        return $this->find($id);
    }
    public function createPartie(Partie $partie): Partie
    {
        $em = $this->getEntityManager();
        $em->persist($partie);
        $em->flush();
        return $partie;
    }

    public function getPartiesByUser($idUser): array
    {
        return $this->findBy(['id_joueur' => $idUser],['status'=>'DESC','created_at'=>'DESC']);
    }

    public function updatePartieScore(int $id, int $score): Partie
    {
        $partie = $this->find($id);
        if ($partie == null) {
            throw new InfraEntityNotFoundException("Partie not found");
        }
        $partie->setScore($score + $partie->getScore());
        $this->getEntityManager()->flush();
        return $partie;
    }

    public function terminerPartie($idPartie){
        $partie = $this->find($idPartie);
        if ($partie == null) {
            throw new InfraEntityNotFoundException("Partie not found");
        }
        $partie->setStatus(0);
        $this->getEntityManager()->flush();
        return $partie;
    }
}

