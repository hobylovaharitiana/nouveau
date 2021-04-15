<?php

namespace App\Entity;

use App\Repository\PersonneTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Personne::class, mappedBy="personneType")
     */
    private $personne;

    public function __construct()
    {
        $this->personne = new ArrayCollection();
    }

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

    /**
     * @return Collection|Personne[]
     */
    public function getPersonne(): Collection
    {
        return $this->personne;
    }

    public function addPersonne(Personne $personne): self
    {
        if (!$this->personne->contains($personne)) {
            $this->personne[] = $personne;
            $personne->setPersonneType($this);
        }

        return $this;
    }

    public function removePersonne(Personne $personne): self
    {
        if ($this->personne->removeElement($personne)) {
            // set the owning side to null (unless already changed)
            if ($personne->getPersonneType() === $this) {
                $personne->setPersonneType(null);
            }
        }

        return $this;
    }
}
