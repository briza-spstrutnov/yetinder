<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $gender;

    #[ORM\Column(type: 'integer')]
    private $height;

    #[ORM\Column(type: 'integer')]
    private $weight;

    #[ORM\Column(type: 'string', length: 255)]
    private $address;

    #[ORM\Column(type: 'integer')]
    private $rating;

    public function getId(): ?int {
        return $this->id;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(string $username): self {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

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

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(string $address): self {
        $this->address = $address;

        return $this;
    }

    public function getRating(): ?int {
        return $this->rating;
    }

    public function setRating(int $rating): self {
        $this->rating = $rating;

        return $this;
    }
}
