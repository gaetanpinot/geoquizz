<?php

namespace Geoquizz\Game\infrastructure\entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Geoquizz\Game\infrastructure\repository\PartieRepository;

#[ORM\Entity(repositoryClass: PartieRepository::class)]
class Partie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_serie = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $id_joueur = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column]
    private ?int $difficulte = null;
    #[ORM\Column]
    private ?int $nb_coups_total = null;

    #[ORM\Column]
    private ?int $score = null;

    /**
     * @var Collection<int, CoupJoue>
     */
    #[ORM\OneToMany(targetEntity: CoupJoue::class, mappedBy: 'partie')]
    private Collection $coups_joue;

    public function __construct()
    {
        $this->coups_joue = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNbCoupsTotal(): ?int
    {
        return $this->nb_coups_total;
    }

    public function setNbCoupsTotal(int $nb_coups_total): static
    {
        $this->nb_coups_total = $nb_coups_total;

        return $this;
    }

    public function getIdSerie(): ?int
    {
        return $this->id_serie;
    }

    public function setIdSerie(int $id_serie): static
    {
        $this->id_serie = $id_serie;

        return $this;
    }

    public function getIdJoueur(): ?string
    {
        return $this->id_joueur;
    }

    public function setIdJoueur(string $id_joueur): static
    {
        $this->id_joueur = $id_joueur;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDifficulte(): ?int
    {
        return $this->difficulte;
    }

    public function setDifficulte(int $difficulte): static
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getCoupsTotal(): ?int
    {
        return $this->nbCoupsTotal;
    }

    public function setCoupsTotal(int $nbCoupsTotal): static
    {
        $this->nbCoupsTotal = $nbCoupsTotal;

        return $this;
    }


    public function addIdImage(CoupJoue $idImage): static
    {
        if (!$this->coups_joue->contains($idImage)) {
            $this->coups_joue->add($idImage);
            $idImage->setPartie($this);
        }

        return $this;
    }

    public function removeIdImage(CoupJoue $idImage): static
    {
        if ($this->coups_joue->removeElement($idImage)) {
            // set the owning side to null (unless already changed)
            if ($idImage->getPartie() === $this) {
                $idImage->setPartie(null);
            }
        }

        return $this;
    }
}
