<?php

namespace App\Entity;

use App\Repository\PanneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanneRepository::class)
 */
class Panne
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
    private $typePanne;

    /**
     * @ORM\ManyToOne(targetEntity=Materiel::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $materiel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypePanne(): ?string
    {
        return $this->typePanne;
    }

    public function setTypePanne(string $typePanne): self
    {
        $this->typePanne = $typePanne;

        return $this;
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
}
