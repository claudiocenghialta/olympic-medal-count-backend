<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AthleteGameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AthleteGameRepository::class)
 * @ApiResource(itemOperations={"get","delete","patch"},collectionOperations={"get","post"},normalizationContext={"groups"={"athlete-games"}})
 */
#[ApiResource]
class AthleteGame
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Athlete::class, inversedBy="athleteGames")
     * @Groups({"athlete-games"})
     */
    private $athlete;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="athleteGames")
     * @Groups({"athlete-games"})
     */
    private $game;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"athlete-games"})
     */
    private $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"athlete-games"})
     */
    private $disqualified;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAthlete(): ?Athlete
    {
        return $this->athlete;
    }

    public function setAthlete(?Athlete $athlete): self
    {
        $this->athlete = $athlete;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDisqualified(): ?bool
    {
        return $this->disqualified;
    }

    public function setDisqualified(?bool $disqualified): self
    {
        $this->disqualified = $disqualified;

        return $this;
    }
}