<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SportRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 * @ApiResource(itemOperations={"get","delete","patch"},collectionOperations={"get","post"},normalizationContext={"groups"={"athlete"}})
 */
class Sport
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=SportCategory::class, inversedBy="sports")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="sport", orphanRemoval=true)
     */
    private $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?SportCategory
    {
        return $this->category;
    }

    public function setCategory(?SportCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGames(Game $games): self
    {
        if (!$this->games->contains($games)) {
            $this->games[] = $games;
            $games->setSport($this);
        }

        return $this;
    }

    public function removeGames(Game $games): self
    {
        if ($this->games->removeElement($games)) {
            // set the owning side to null (unless already changed)
            if ($games->getSport() === $this) {
                $games->setSport(null);
            }
        }

        return $this;
    }
}
