<?php

namespace App\Entity;

use App\Repository\FavoritePoiRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Poi;

#[ORM\Entity(repositoryClass: FavoritePoiRepository::class)]
#[ORM\Table(
    name: 'favorites_pois',
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'UNIQ_USER_POI', columns: ['user_id', 'poi_id']),
    ]
    // 👇 On supprime la déclaration explicite de l’index sur user_id
)]
class FavoritePoi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'favorite_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'user_id', nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Poi::class)]
    #[ORM\JoinColumn(name: 'poi_id', referencedColumnName: 'poi_id', nullable: false, onDelete: 'CASCADE')]
    private Poi $poi;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getUser(): User { return $this->user; }
    public function setUser(User $user): self { $this->user = $user; return $this; }
    public function getPoi(): Poi { return $this->poi; }
    public function setPoi(Poi $poi): self { $this->poi = $poi; return $this; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}