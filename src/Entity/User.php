<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'user_id')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $lastName = null;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private ?string $username = null;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $password = null;

    #[ORM\Column(name: 'auth_provider', type: 'string', length: 50, nullable: true)]
    private ?string $authProvider = null;

    #[ORM\Column(name: 'phone_number', type: 'string', length: 20, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(name: 'profile_picture_url', type: 'string', length: 255, nullable: true)]
    private ?string $profilePictureUrl = null;

    #[ORM\Column(name: 'address', type: 'string', length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(name: 'last_login', type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lastLogin = null;

    #[ORM\Column(name: 'is_active', type: 'boolean')]
    private bool $isActive = true;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Role::class)]
    #[ORM\JoinTable(
        name: 'roles_user',
        joinColumns: [new ORM\JoinColumn(name: 'user_id', referencedColumnName: 'user_id')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'role_id', referencedColumnName: 'role_id')]
    )]
    private Collection $roles;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: FavoriteLocation::class, orphanRemoval: true)]
    private Collection $favoriteLocations;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->favoriteLocations = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getFirstName(): ?string { return $this->firstName; }
    public function setFirstName(?string $f): self { $this->firstName = $f; return $this; }

    public function getLastName(): ?string { return $this->lastName; }
    public function setLastName(?string $l): self { $this->lastName = $l; return $this; }

    public function getName(): string
    {
        return trim(($this->firstName ?? '') . ' ' . ($this->lastName ?? ''));
    }

    public function getUsername(): ?string { return $this->username; }
    public function setUsername(string $u): self { $this->username = $u; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $e): self { $this->email = $e; return $this; }

    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $p): self { $this->password = $p; return $this; }

    public function getPhoneNumber(): ?string { return $this->phoneNumber; }
    public function setPhoneNumber(?string $p): self { $this->phoneNumber = $p; return $this; }

    public function getProfilePictureUrl(): ?string { return $this->profilePictureUrl; }
    public function setProfilePictureUrl(?string $u): self { $this->profilePictureUrl = $u; return $this; }

    public function getAddress(): ?string { return $this->address; }
    public function setAddress(?string $a): self { $this->address = $a; return $this; }

    public function getLastLogin(): ?\DateTimeInterface { return $this->lastLogin; }
    public function setLastLogin(?\DateTimeInterface $d): self { $this->lastLogin = $d; return $this; }

    public function isActive(): bool { return $this->isActive; }
    public function setIsActive(bool $b): self { $this->isActive = $b; return $this; }

    public function getCreatedAt(): ?\DateTimeInterface { return $this->createdAt; }
    public function getUpdatedAt(): ?\DateTimeInterface { return $this->updatedAt; }

    public function getUserIdentifier(): string { return $this->email ?? ''; }

    /** @deprecated Symfony 5 */
    public function getUsernameLegacy(): string { return $this->email ?? ''; }

    public function eraseCredentials(): void {}

    public function getRoles(): array
    {
        $names = array_map(fn(Role $r) => $r->getRoleName(), $this->roles->toArray());
        $names[] = 'ROLE_USER';
        return array_unique($names);
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    public function getRoleEntities(): Collection
    {
        return $this->roles;
    }

    public function getFavoriteLocations(): Collection
    {
        return $this->favoriteLocations;
    }

    public function addFavoriteLocation(FavoriteLocation $favoriteLocation): self
    {
        if (!$this->favoriteLocations->contains($favoriteLocation)) {
            $this->favoriteLocations[] = $favoriteLocation;
            $favoriteLocation->setUser($this);
        }

        return $this;
    }

    public function removeFavoriteLocation(FavoriteLocation $favoriteLocation): self
    {
        if ($this->favoriteLocations->removeElement($favoriteLocation)) {
            if ($favoriteLocation->getUser() === $this) {
                $favoriteLocation->setUser(null);
            }
        }

        return $this;
    }
}