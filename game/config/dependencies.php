<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMSetup;
use Geoquizz\Game\core\services\PartieService;
use Geoquizz\Game\core\services\interfaces\PartieServiceInterface;
use Geoquizz\Game\infrastructure\entities\Partie;
use Geoquizz\Game\infrastructure\interfaces\PartieInfraInterface;
use Geoquizz\Game\infrastructure\repository\PartieRepository;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Doctrine\DBAL\Connection;

use function DI\get;

return [

    PartieServiceInterface::class => DI\get(PartieService::class),
    PartieInfraInterface::class => DI\get(PartieRepository::class),

    PartieService::class => DI\autowire(),

    'doctrine.entities' => __DIR__ . "/../src/infrastructure/entities",

    'doctrine.config' => function (ContainerInterface $c) {
        return ORMSetup::createAttributeMetadataConfiguration([$c->get('doctrine.entities')], true);
    } ,
    'db.config' => parse_ini_file(__DIR__ . "/db.ini"),
    Connection::class => function (ContainerInterface $c) {
        return DriverManager::getConnection($c->get('db.config'), $c->get('doctrine.config'));
    },

    EntityManager::class => DI\autowire()->constructor(get(Connection::class), get('doctrine.config')),

    PartieRepository::class => function ($c) {
        return $c->get(EntityManager::class)->getRepository(Partie::class);
    },


];
