<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 * @ApiResource(itemOperations={"get","delete","patch"},collectionOperations={"get","post"},normalizationContext={"groups"={"games"}})
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"games"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="athlete")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"games"})
     */
    private $sport;


    /**
     * @ORM\OneToMany(targetEntity=AthleteGame::class, mappedBy="game")
     * @Groups({"games"})
     * 
     */
    private $athleteGames;

    public function __construct()
    {
        $this->athlete = new ArrayCollection();
        $this->athleteGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }


    /**
     * @return Collection|AthleteGame[]
     */
    public function getAthleteGames(): Collection
    {
        return $this->athleteGames;
    }

    public function addAthleteGame(AthleteGame $athleteGame): self
    {
        if (!$this->athleteGames->contains($athleteGame)) {
            $this->athleteGames[] = $athleteGame;
            $athleteGame->setGame($this);
        }

        return $this;
    }

    public function removeAthleteGame(AthleteGame $athleteGame): self
    {
        if ($this->athleteGames->removeElement($athleteGame)) {
            // set the owning side to null (unless already changed)
            if ($athleteGame->getGame() === $this) {
                $athleteGame->setGame(null);
            }
        }

        return $this;
    }
}
