<?php declare(strict_types=1);

namespace App\Tests\Shipment\Stubs;

use App\Shipment\Domain\Stop;
use App\Shipment\Domain\StopRepository;

final class InMemoryStopRepository implements StopRepository
{
    /** @var array<int, Stop> */
    private array $data = [];

    public function save(Stop $shipment): void
    {
        $this->data[$shipment->getId()] = $shipment;
    }

    public function find(int $id): ?Stop
    {
        if (!isset($this->data[$id])) {
            return null;
        }

        return $this->data[$id];
    }
}
