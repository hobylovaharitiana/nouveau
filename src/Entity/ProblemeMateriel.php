<?php

namespace App\Entity;

use App\Repository\ProblemeMaterielRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProblemeMaterielRepository::class)
 */
class ProblemeMateriel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Materiel::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $materiel;

    /**
     * @ORM\ManyToOne(targetEntity=Panne::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $panne;

    private $nombrePanne;

    public function getNombrePanne(): ?string
    {
        return $this->nombrePanne;
    }

    public function setNombrePanne(string $nombrePanne): self
    {
        $this->nombrePanne = $nombrePanne;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiel $materiel): self
    {
        $this->materiel = $materiel;

        return $this;
    }

    public function getPanne(): ?Panne
    {
        return $this->panne;
    }

    public function setPanne(?Panne $panne): self
    {
        $this->panne = $panne;

        return $this;
    }

}
