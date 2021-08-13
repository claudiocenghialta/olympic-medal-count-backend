<?php

namespace App\Entity;

use App\Repository\SportCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportCategoryRepository::class)
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
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Sport::class, mappedBy="category", orphanRemoval=true)
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
