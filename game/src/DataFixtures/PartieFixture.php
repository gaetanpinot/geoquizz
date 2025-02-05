<?php

namespace Geoquizz\Game\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Geoquizz\Game\infrastructure\entities\Partie;

class PartieFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0;$i<5;$i++){
            $partie = new Partie();
            $partie->setScore(40 + $i*10);
            $partie->setIdSerie($i);

            $partie->setIdJoueur('a0eebc99-9c0b-4ef8-bb6d-6bb9bd380a11');
            $partie->setStatus(1);
            $partie->setDifficulte(1);
            $manager->persist($partie);
            $manager->flush();
        }
    }
}