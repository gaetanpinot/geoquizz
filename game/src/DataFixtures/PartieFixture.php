<?php

namespace Geoquizz\Game\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Geoquizz\Game\infrastructure\entities\Partie;

class PartieFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $partie = new Partie();
        $partie->setScore(40);
        $partie->setIdSerie(1);
        //uuid
        $partie->setIdJoueur('a0eebc99-9c0b-4ef8-bb6d-6bb9bd380a11');
        $partie->setStatus(1);
        $partie->setDifficulte(1);
        $manager->persist($partie);


        $manager->flush();
    }
}
