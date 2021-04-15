<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterielRepository::class)
 */
class Materiel
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
    private $nomMateriel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marqueMateriel;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $caracteristique;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="materiels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personnes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMateriel(): ?string
    {
        return $this->nomMateriel;
    }

    public function setNomMateriel(string $nomMateriel): self
    {
        $this->nomMateriel = $nomMateriel;

        return $this;
    }

    public function getMarqueMateriel(): ?string
    {
        return $this->marqueMateriel;
    }

    public function setMarqueMateriel(string $marqueMateriel): self
    {
        $this->marqueMateriel = $marqueMateriel;

        return $this;
    }

    public function getCaracteristique(): ?string
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(?string $caracteristique): self
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }

    public function getPersonnes(): ?Personne
    {
        return $this->personnes;
    }

    public function setPersonnes(?Personne $personnes): self
    {
        $this->personnes = $personnes;

        return $this;
    }
}
