<?php

namespace App\Entity;

use App\Repository\PersonneTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonneTypeRepository::class)
 */
class PersonneType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specialite;

    /**
     * @ORM\Column(type="integer")
     */
    private $idPersonne;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="personneType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomType(): ?string
    {
        return $this->nomType;
    }

    public function setNomType(string $nomType): self
    {
        $this->nomType = $nomType;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getIdPersonne(): ?int
    {
        return $this->idPersonne;
    }

    public function setIdPersonne(int $idPersonne): self
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }
}
