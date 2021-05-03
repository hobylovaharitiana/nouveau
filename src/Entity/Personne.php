<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
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
    private $nomPersonne;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomPersonne;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $emailPersonne;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min="10",max="10",minMessage="Votre numero doit comporter 10 caracteres", maxMessage="Votre numero doit comporter 10 caracteres")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=PersonneType::class, inversedBy="personne")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personneType;
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPersonne(): ?string
    {
        return $this->nomPersonne;
    }

    public function setNomPersonne(string $nomPersonne): self
    {
        $this->nomPersonne = $nomPersonne;

        return $this;
    }

    public function getPrenomPersonne(): ?string
    {
        return $this->prenomPersonne;
    }

    public function setPrenomPersonne(string $prenomPersonne): self
    {
        $this->prenomPersonne = $prenomPersonne;

        return $this;
    }

    public function getEmailPersonne(): ?string
    {
        return $this->emailPersonne;
    }

    public function setEmailPersonne(string $emailPersonne): self
    {
        $this->emailPersonne = $emailPersonne;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPersonneType(): ?PersonneType
    {
        return $this->personneType;
    }

    public function setPersonneType(?PersonneType $personneType): self
    {
        $this->personneType = $personneType;

        return $this;
    }
}
