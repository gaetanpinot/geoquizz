<?php

namespace Geoquizz\Game\infrastructure\entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Geoquizz\Game\infrastructure\repository\CoupJoueRepository;

#[ORM\Entity(repositoryClass: CoupJoueRepository::class)]
#[ORM\Table(name: 'coup_joue')]
class CoupJoue
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'id_point')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Partie $partie = null;

    #[ORM\Column]
    private ?int $id_point = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_joue = null;

    #[ORM\Column(nullable: true)]
    private ?float $lat = null;

    #[ORM\Column(nullable: true)]
    private ?float $long = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartie(): ?Partie
    {
        return $this->partie;
    }

    public function setPartie(?Partie $partie): static
    {
        $this->partie = $partie;

        return $this;
    }

    public function getIdPoint(): ?int
    {
        return $this->id_point;
    }

    public function setIdPoint(string $id_point): static
    {
        $this->id_point = $id_point;

        return $this;
    }

    public function getDateJoue(): ?\DateTimeInterface
    {
        return $this->date_joue;
    }

    public function setDateJoue(?\DateTimeInterface $date_joue): static
    {
        $this->date_joue = $date_joue;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLong(): ?float
    {
        return $this->long;
    }

    public function setLong(?float $long): static
    {
        $this->long = $long;

        return $this;
    }
}