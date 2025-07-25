<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'floors')]
class Floor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'floor_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'location_id', onDelete: 'CASCADE')]
    private ?Location $location = null;

    #[ORM\Column(name: 'floor_label', length: 50)]
    private string $label;

    #[ORM\Column(name: 'floor_number', type: 'integer')]
    private int $number;

    public function getId(): ?int { return $this->id; }
    public function getLocation(): ?Location { return $this->location; }
    public function setLocation(?Location $l): self { $this->location = $l; return $this; }
    public function getLabel(): string { return $this->label; }
    public function setLabel(string $l): self { $this->label = $l; return $this; }
    public function getNumber(): int { return $this->number; }
    public function setNumber(int $n): self { $this->number = $n; return $this; }
}