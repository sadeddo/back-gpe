<?php

namespace App\Entity;

use App\Repository\FavoriteLocationRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Location;

#[ORM\Entity(repositoryClass: FavoriteLocationRepository::class)]
#[ORM\Table(
    name: 'favorites_locations',
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'UNIQ_USER_LOCATION', columns: ['user_id', 'location_id']),
    ]
    // ✅ Aucun index explicite sur user_id, on évite le conflit Doctrine/MySQL
)]
class FavoriteLocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'favorite_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'favoriteLocations')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'user_id', nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'location_id', nullable: false, onDelete: 'CASCADE')]
    private Location $location;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getUser(): User { return $this->user; }
    public function setUser(User $user): self { $this->user = $user; return $this; }
    public function getLocation(): Location { return $this->location; }
    public function setLocation(Location $location): self { $this->location = $location; return $this; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}