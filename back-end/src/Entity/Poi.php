<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Location;
use App\Entity\Floor;
use App\Entity\Beacon;

#[ORM\Entity(repositoryClass: 'App\Repository\PoiRepository')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'pois')]
class Poi
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(name: 'poi_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'location_id', onDelete: 'CASCADE')]
    private Location $location;

    #[ORM\ManyToOne(targetEntity: Floor::class)]
    #[ORM\JoinColumn(name: 'floor_id',    referencedColumnName: 'floor_id',    onDelete: 'SET NULL')]
    private ?Floor $floor = null;

    #[ORM\ManyToOne(targetEntity: Beacon::class)]
    #[ORM\JoinColumn(name: 'beacon_id',   referencedColumnName: 'beacon_id',   onDelete: 'SET NULL')]
    private ?Beacon $beacon = null;

    #[ORM\Column(type: 'string', length: 100)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string', length: 50)]
    private string $type;

    #[ORM\Column(type: 'string', length: 50)]
    private string $category;

    #[ORM\Column(type: 'float')]
    private float $latitude;

    #[ORM\Column(type: 'float')]
    private float $longitude;

    #[ORM\Column(name: 'is_accessible', type: 'boolean')]
    private bool $isAccessible = false;

    #[ORM\Column(name: 'opening_hours',   type: 'string', length: 100)]
    private string $openingHours;

    #[ORM\Column(name: 'closing_soon',    type: 'boolean')]
    private bool $closingSoon = false;

    #[ORM\Column(name: 'created_at',     type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at',     type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getFloor(): ?Floor
    {
        return $this->floor;
    }

    public function setFloor(?Floor $floor): self
    {
        $this->floor = $floor;
        return $this;
    }

    public function getBeacon(): ?Beacon
    {
        return $this->beacon;
    }

    public function setBeacon(?Beacon $beacon): self
    {
        $this->beacon = $beacon;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function isAccessible(): bool
    {
        return $this->isAccessible;
    }

    public function setIsAccessible(bool $isAccessible): self
    {
        $this->isAccessible = $isAccessible;
        return $this;
    }

    public function getOpeningHours(): string
    {
        return $this->openingHours;
    }

    public function setOpeningHours(string $openingHours): self
    {
        $this->openingHours = $openingHours;
        return $this;
    }

    public function isClosingSoon(): bool
    {
        return $this->closingSoon;
    }

    public function setClosingSoon(bool $closingSoon): self
    {
        $this->closingSoon = $closingSoon;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}