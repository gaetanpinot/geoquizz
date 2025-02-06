<?php

namespace Geoquizz\Game\core\services;

use Geoquizz\Game\core\dto\CoupConfirmeResponseDTO;
use Geoquizz\Game\core\dto\CoupNextResponseDTO;
use Geoquizz\Game\core\dto\JouerCoupDTO;
use Geoquizz\Game\core\services\exceptions\ServicePartieTermineException;
use Geoquizz\Game\core\services\interfaces\CoupJoueServiceInterface;
use Geoquizz\Game\infrastructure\exceptions\InfraPartieTermineException;
use Geoquizz\Game\infrastructure\interfaces\CoupJoueRepositoryInterface;
use Geoquizz\Game\infrastructure\interfaces\PartieInfraInterface;
use Geoquizz\Game\infrastructure\interfaces\PointRepositoryInterface;

class CoupJoueService implements CoupJoueServiceInterface
{
    private const DISTANCE_BASE = 1000;
    private const NB_SECONDES = 30;

    protected CoupJoueRepositoryInterface $coupsJoueRepository;
    protected PointRepositoryInterface $pointRepository;

    protected PartieInfraInterface $partieRepository;

    public function __construct(CoupJoueRepositoryInterface $coupsJoueRepository, PointRepositoryInterface $pointRepository, PartieInfraInterface $partieRepository)
    {
        $this->coupsJoueRepository = $coupsJoueRepository;
        $this->pointRepository = $pointRepository;
        $this->partieRepository = $partieRepository;
    }

    public function joueCoup(JouerCoupDTO $jouerCoupDTO): CoupConfirmeResponseDTO{
        try {

            $dateTime = new \DateTime();
            $coupJoue = $this->coupsJoueRepository->joueCoup($jouerCoupDTO);

            $coeffHeure = $this->calculerCoeffHeure($this->calculerHeureCoup($coupJoue->getDateJoue(), $dateTime));

            $point = $this->pointRepository->getPoint($coupJoue->getIdPoint());

            $d = self::DISTANCE_BASE * $coupJoue->getPartie()->getDifficulte();
            $scoreDistance = $this->calculerScoreDistance($jouerCoupDTO->getLat(), $jouerCoupDTO->getLon(), $point['lat'], $point['long'], $d);

            $scoreIncrem =  $scoreDistance * $coeffHeure;

            $scoreTotal = $this->partieRepository->updatePartieScore($coupJoue->getPartie()->getId(), $scoreIncrem)->getScore();

        } catch(InfraPartieTermineException $e) {
            throw new ServicePartieTermineException();
        }
        return new CoupConfirmeResponseDTO($point['lat'], $point['long'], $scoreTotal);
    }

    public function nextCoup(int $idPartie): CoupNextResponseDTO
    {
        $now = new \DateTime();
        $date = $this->coupsJoueRepository->modifCoupDateJoue($idPartie);

        //diff en secondes
        $diff =  ($date->getTimestamp() + self::NB_SECONDES) - $now->getTimestamp();

        $res = $this->coupsJoueRepository->prochainCoup($idPartie);

        $idImage = $this->pointRepository->getPoint($res->getIdPoint())['image'];

        $nbCoupsRestant = $this->coupsJoueRepository->calculerNbCoupsRestant($idPartie);
        if ($nbCoupsRestant == 0)
            $this->partieRepository->terminerPartie($idPartie);

        return new CoupNextResponseDTO($nbCoupsRestant, $idImage, $diff);
    }


    private function calculerScoreDistance(float $userLat, float $userLon, float $targetLat, float $targetLon, int $d): int
    {
        $earthRadius = 6371000;

        $userLatRad = deg2rad($userLat);
        $targetLatRad = deg2rad($targetLat);
        $deltaLat = deg2rad($targetLat - $userLat);
        $deltaLon = deg2rad($targetLon - $userLon);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos($userLatRad) * cos($targetLatRad) *
            sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        if ($distance < $d)
            return 5;
        if ($distance < 2 * $d)
            return 3;
        if ($distance < 3 * $d)
            return 1;

        return 0;
    }

    private function calculerHeureCoup($dateCoup, $dateNow){
        //diff en secondes
        $diff =  $dateNow->getTimestamp() - $dateCoup->getTimestamp();
        return $diff;
    }

    private function calculerCoeffHeure($heureCoup){
        if ($heureCoup < 5)
            $coeff = 4;
        else if ($heureCoup < 10)
            $coeff = 2;
        else if ($heureCoup < 20)
            $coeff = 1;
        else
            $coeff = 0;

        return $coeff;
    }
}