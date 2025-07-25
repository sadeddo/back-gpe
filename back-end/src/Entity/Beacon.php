<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'beacons')]
class Beacon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'beacon_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'location_id', onDelete: 'CASCADE')]
    private ?Location $location = null;

    #[ORM\Column(name: 'beacon_uuid', length: 100)]
    private string $uuid;

    #[ORM\Column(length: 50)]
    private string $identifier;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'float')]
    private float $latitude;

    #[ORM\Column(type: 'float')]
    private float $longitude;

    public function getId(): ?int { return $this->id; }
    public function getLocation(): ?Location { return $this->location; }
    public function setLocation(?Location $l): self { $this->location = $l; return $this; }
    public function getUuid(): string { return $this->uuid; }
    public function setUuid(string $u): self { $this->uuid = $u; return $this; }
    public function getIdentifier(): string { return $this->identifier; }
    public function setIdentifier(string $i): self { $this->identifier = $i; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $d): self { $this->description = $d; return $this; }
    public function getLatitude(): float { return $this->latitude; }
    public function setLatitude(float $lat): self { $this->latitude = $lat; return $this; }
    public function getLongitude(): float { return $this->longitude; }
    public function setLongitude(float $lng): self { $this->longitude = $lng; return $this; }
}