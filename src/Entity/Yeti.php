<?php

namespace App\Entity;

use App\Repository\YetiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YetiRepository::class)]
class Yeti {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $gender;

    #[ORM\Column(type: 'integer')]
    private $height;

    #[ORM\Column(type: 'integer')]
    private $weight;

    #[ORM\Column(type: 'integer')]
    private $rating;

    #[ORM\Column(type: 'string', length: 255)]
    private $phoneNumber;

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getGender(): ?string {
        return $this->gender;
    }

    public function setGender(string $gender): self {
        $this->gender = $gender;

        return $this;
    }

    public function getHeight(): ?int {
        return $this->height;
    }

    public function setHeight(int $height): self {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?int {
        return $this->weight;
    }

    public function setWeight(int $weight): self {
        $this->weight = $weight;

        return $this;
    }

    public function getRating(): ?int {
        return $this->rating;
    }

    public function setRating(int $rating): self {
        $this->rating = $rating;

        return $this;
    }

    public function getPhoneNumber(): ?string {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
