<?php

namespace App\Entity;

use App\Repository\TimeClickRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeClickRepository::class)]
class TimeClick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $time;

    #[ORM\Column(type: 'integer')]
    private $clicks;

    #[ORM\Column(type: 'string', length: 255)]
    private $dayTime;

    #[ORM\Column(type: 'string')]
    private $endTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getClicks(): ?int
    {
        return $this->clicks;
    }

    public function setClicks(int $clicks): self
    {
        $this->clicks = $clicks;

        return $this;
    }

    public function getDayTime(): ?string
    {
        return $this->dayTime;
    }

    public function setDayTime(string $dayTime): self
    {
        $this->dayTime = $dayTime;

        return $this;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    public function setEndTime(string $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }
}
