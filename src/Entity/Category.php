<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Bedroom::class, inversedBy: 'categories')]
    private Collection $category_bedroom;

    public function __construct()
    {
        $this->category_bedroom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Bedroom>
     */
    public function getCategoryBedroom(): Collection
    {
        return $this->category_bedroom;
    }

    public function addCategoryBedroom(Bedroom $categoryBedroom): static
    {
        if (!$this->category_bedroom->contains($categoryBedroom)) {
            $this->category_bedroom->add($categoryBedroom);
        }

        return $this;
    }

    public function removeCategoryBedroom(Bedroom $categoryBedroom): static
    {
        $this->category_bedroom->removeElement($categoryBedroom);

        return $this;
    }
}
