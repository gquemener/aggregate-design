<?php declare(strict_types=1);

namespace App\Tests\Shipment\Stubs;

use App\Shipment\Domain\Shipment;
use App\Shipment\Domain\ShipmentRepository;

final class InMemoryShipmentRepository implements ShipmentRepository
{
    /** @var array<int, Shipment> */
    private array $data = [];

    public function save(Shipment $shipment): void
    {
        $this->data[$shipment->getId()] = $shipment;
    }

    public function find(int $id): ?Shipment
    {
        if (!isset($this->data[$id])) {
            return null;
        }

        return $this->data[$id];
    }
}
