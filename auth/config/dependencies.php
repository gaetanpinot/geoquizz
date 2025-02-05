<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Geoquizz\Auth\CorsMiddleware;
use Geoquizz\Auth\core\repositoryInterfaces\AuthRepositoryInterface;
use Geoquizz\Auth\core\services\ServiceAuth;
use Geoquizz\Auth\core\services\ServiceAuthInterface;
use Geoquizz\Auth\infrastructure\entities\Utilisateur;
use Geoquizz\Auth\infrastructure\repositories\UtilisateurRepository;
use Geoquizz\Auth\providers\auth\AuthnProviderInterface;
use Geoquizz\Auth\providers\auth\JWTAuthnProvider;
use Geoquizz\Auth\providers\auth\JWTManager;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Doctrine\DBAL\Connection;

use function DI\get;

return [

    AuthnProviderInterface::class => DI\get(JWTAuthnProvider::class),
    JWTAuthnProvider::class => DI\autowire(),
    ServiceAuthInterface::class => DI\get(ServiceAuth::class),
    ServiceAuth::class => DI\autowire(),
    AuthRepositoryInterface::class => DI\get(UtilisateurRepository::class),
    UtilisateurRepository::class => function (ContainerInterface $c) {
        return $c->get(EntityManager::class)->getRepository(Utilisateur::class);
    },
    JWTManager::class => DI\create()->constructor(
        get('jwt.tempsvalidite'),
        get('jwt.emmeteur'),
        get('jwt.audience'),
        get('jwt.key'),
        get('jwt.algo')
    ),

    'doctrine.entities' => __DIR__ . "/../src/infrastructure/entities",

    'doctrine.config' => function (ContainerInterface $c) {
        return ORMSetup::createAttributeMetadataConfiguration([$c->get('doctrine.entities')], true);
    } ,
    'db.config' => parse_ini_file(__DIR__ . "/db.ini"),
    Connection::class => function (ContainerInterface $c) {
        return DriverManager::getConnection($c->get('db.config'), $c->get('doctrine.config'));
    },

    EntityManager::class => DI\autowire()->constructor(get(Connection::class), get('doctrine.config')),

    CorsMiddleware::class => DI\autowire(),



];
