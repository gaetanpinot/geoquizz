<?php

namespace Geoquizz\Auth\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Geoquizz\Auth\infrastructure\entities\Utilisateur;
use Faker\Factory;
use Utilisateur as UtilisateurUtilisateur;

class UtilisateurFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail('user@mail.com');
        $utilisateur->setMotDePasse(password_hash('user', PASSWORD_DEFAULT));
        $utilisateur->setNom('Utilisateur');
        $utilisateur->setPrenom('Super');
        $manager->persist($utilisateur);
        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 10; $i++) {

            $nom = $faker->lastName;
            $prenom = $faker->firstName;
            $domain = $faker->domainName();
            $u = new Utilisateur();
            $u->setEmail("$prenom.$nom@$domain");
            $u->setMotDePasse(password_hash('1234', PASSWORD_DEFAULT));
            $u->setNom($nom);
            $u->setPrenom($prenom);
            $manager->persist($u);

        }

        $manager->flush();
    }
}
