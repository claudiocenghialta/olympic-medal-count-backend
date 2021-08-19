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
     * @ORM\ManyToMany(targetEntity=Athlete::class, inversedBy="games")
     * @Groups({"games"})
     */
    private $athlete;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"games"})
     */
    private $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"games"})
     */
    private $disqualified;

    public function __construct()
    {
        $this->athlete = new ArrayCollection();
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
     * @return Collection|Athlete[]
     */
    public function getAthlete(): Collection
    {
        return $this->athlete;
    }

    public function addAthlete(Athlete $athlete): self
    {
        if (!$this->athlete->contains($athlete)) {
            $this->athlete[] = $athlete;
        }

        return $this;
    }

    public function removeAthlete(Athlete $athlete): self
    {
        $this->athlete->removeElement($athlete);

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
