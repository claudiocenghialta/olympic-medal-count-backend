<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

use App\Repository\SportCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportCategoryRepository::class)
 * @ApiResource(itemOperations={"get","delete","patch"},collectionOperations={"get","post"},normalizationContext={"groups"={"sports-categories"}})
 */
class SportCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"sports-categories"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Sport::class, mappedBy="category", orphanRemoval=true)
     * @Groups({"sports-categories"})
     */
    private $sports;

    public function __construct()
    {
        $this->sports = new ArrayCollection();
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

    /**
     * @return Collection|Sport[]
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sport $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
            $sport->setCategory($this);
        }

        return $this;
    }

    public function removeSport(Sport $sport): self
    {
        if ($this->sports->removeElement($sport)) {
            // set the owning side to null (unless already changed)
            if ($sport->getCategory() === $this) {
                $sport->setCategory(null);
            }
        }

        return $this;
    }
}
