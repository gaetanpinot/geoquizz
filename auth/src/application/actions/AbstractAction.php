<?php

namespace Geoquizz\Auth\application\actions;


use DI\Container;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Geoquizz\Auth\core\services\ServiceAuthInterface;
use Geoquizz\Auth\core\services\praticien\ServicePraticienInterface;
use Geoquizz\Auth\core\services\rdv\ServiceRDVInterface;
use Geoquizz\Auth\providers\auth\AuthnProviderInterface;
use Geoquizz\Auth\core\services\patient\ServicePatientInterface;

abstract class AbstractAction
{
    protected AuthnProviderInterface $authProvider;
    protected string $formatDate;
    protected Container $cont;

    protected Logger $loger;

    public function __construct(Container $cont)
    {
        $this->authProvider = $cont->get(AuthnProviderInterface::class);
        $this->formatDate = $cont->get('date.format');
        $this->loger = $cont->get(Logger::class)->withName(get_class($this));
        

    }

    /**
     * @param array<int,mixed> $args
     */
    abstract public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface ;
    

}
