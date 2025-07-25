<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table(name: 'roles')]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'role_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'role_name', type: 'string', length: 50, unique: true)]
    private string $roleName;

    #[ORM\Column(name: 'role_description', type: 'text', nullable: true)]
    private ?string $description = null;

    public function getId(): ?int { return $this->id; }

    public function getRoleName(): string { return $this->roleName; }
    public function setRoleName(string $name): self { $this->roleName = $name; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $desc): self { $this->description = $desc; return $this; }
}