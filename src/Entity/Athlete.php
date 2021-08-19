<?php

namespace App\Entity;

use App\Repository\AthleteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AthleteRepository::class)
 * @ApiResource(itemOperations={"get","delete","patch"},collectionOperations={"get","post"},normalizationContext={"groups"={"athlete"}})
 */
class Athlete
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"athlete"})
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"athlete"})
     */
    private $last_name;

    /**
     * @ORM\ManyToOne(targetEntity=Nation::class, inversedBy="athletes")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"athlete"})
     */
    private $nation;


    /**
     * @ORM\OneToMany(targetEntity=AthleteGame::class, mappedBy="athlete")
     * @Groups({"athlete"})
     */
    private $athleteGames;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->athleteGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getNation(): ?Nation
    {
        return $this->nation;
    }

    public function setNation(?Nation $nation): self
    {
        $this->nation = $nation;

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
            $athleteGame->setAthlete($this);
        }

        return $this;
    }

    public function removeAthleteGame(AthleteGame $athleteGame): self
    {
        if ($this->athleteGames->removeElement($athleteGame)) {
            // set the owning side to null (unless already changed)
            if ($athleteGame->getAthlete() === $this) {
                $athleteGame->setAthlete(null);
            }
        }

        return $this;
    }
}
