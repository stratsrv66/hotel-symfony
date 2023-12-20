<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: 'hotel_id', targetEntity: Bedroom::class)]
    private Collection $bedrooms;

    public function __construct()
    {
        $this->bedrooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Bedroom>
     */
    public function getBedrooms(): Collection
    {
        return $this->bedrooms;
    }

    public function addBedroom(Bedroom $bedroom): static
    {
        if (!$this->bedrooms->contains($bedroom)) {
            $this->bedrooms->add($bedroom);
            $bedroom->setHotelId($this);
        }

        return $this;
    }

    public function removeBedroom(Bedroom $bedroom): static
    {
        if ($this->bedrooms->removeElement($bedroom)) {
            // set the owning side to null (unless already changed)
            if ($bedroom->getHotelId() === $this) {
                $bedroom->setHotelId(null);
            }
        }

        return $this;
    }
}
