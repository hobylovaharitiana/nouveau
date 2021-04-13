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
}
