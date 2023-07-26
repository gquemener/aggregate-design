<?php declare(strict_types=1);

namespace App\ProjectOvation\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Version;

#[Entity]
final class Product
{
    #[Id, GeneratedValue('NONE'), Column(type: 'product_id')]
    private ProductId $id;

    #[Column(type: 'integer'), Version]
    private int $version;

    #[Column]
    private string $name;

    #[Column]
    private string $description;

    #[OneToMany(targetEntity: BacklogItem::class, mappedBy: 'product')]
    private Collection $backlogItems;

    #[OneToMany(targetEntity: Release::class, mappedBy: 'product')]
    private Collection $releases;

    #[OneToMany(targetEntity: Sprint::class, mappedBy: 'product')]
    private Collection $sprints;

    #[Embedded]
    private TenantId $tenantId;

    public function __construct()
    {
        $this->backlogItems = new ArrayCollection();
        $this->releases = new ArrayCollection();
        $this->sprints = new ArrayCollection();
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param array<BacklogItem> $backlogItems
     */
    public function setBacklogItems(array $backlogItems): void
    {
        $this->backlogItems = $backlogItems;
    }

    public function getBacklogItems(): array
    {
        return $this->backlogItems;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @param array<Release> $releases
     */
    public function setReleases(array $releases): void
    {
        $this->releases = $releases;
    }

    public function getReleases(): array
    {
        return $this->releases;
    }
    /**
     * @param array<Sprint> $sprints
     */
    public function setSprints(array $sprints): void
    {
        $this->sprints = $sprints;
    }

    public function getSprints(): array
    {
        return $this->sprints;
    }

    public function setTenantId(TenantId $tenantId): void
    {
        $this->tenantId = $tenantId;
    }

    public function getTenantId(): ?TenantId
    {
        return $this->tenantId;
    }
}
