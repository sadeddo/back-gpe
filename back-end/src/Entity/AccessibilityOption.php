<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Location;

#[ORM\Entity]
#[ORM\Table(name: 'accessibility_options')]
class AccessibilityOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'option_id')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'location_id')]
    private Location $location;

    #[ORM\Column(name: 'option_type', length: 50)]
    private string $optionType;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    public function getId(): ?int { return $this->id; }
    public function getLocation(): Location { return $this->location; }
    public function setLocation(Location $location): self { $this->location = $location; return $this; }
    public function getOptionType(): string { return $this->optionType; }
    public function setOptionType(string $type): self { $this->optionType = $type; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $desc): self { $this->description = $desc; return $this; }
}