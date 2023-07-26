<?php

declare(strict_types=1);

namespace App\Shipment\Application;

use App\Shipment\Domain\Shipment;
use App\Shipment\Domain\ShipmentRepository;
use App\Shipment\Domain\Stop;
use InvalidArgumentException;
use LogicException;

final class ShipmentService
{
    public function __construct(private readonly ShipmentRepository $repository)
    {
    }

    /**
     * @param array<Stop> $stops
     */
    public function scheduleShipment(int $id, array $stops): void {
        $shipment = new Shipment($id);
        foreach ($stops as $stop) {
            $shipment->addStop($stop);
        }

        $this->repository->save($shipment);
    }

    public function arriveAtStop(int $shipmentId, int $stopId): void
    {
        $shipment = $this->repository->find($shipmentId);
        if (!$shipment) {
            throw new InvalidArgumentException(sprintf('Shipment "%s" was not found.', $shipmentId));
        }

        $previousStop = null;
        foreach ($shipment->getStops() as $stop) {
            if ($stop->getId() === $stopId) {
                if ($previousStop && $previousStop->getStatus() !== 'departed') {
                    throw new LogicException('Cannot arrive at stop %d before departing stop %d.');
                }
                $stop->setStatus('arrived');
            }
            $previousStop = $stop;
        }

        $this->repository->save($shipment);
    }

    public function departFromStop(int $shipmentId, int $stopId): void
    {
        $shipment = $this->repository->find($shipmentId);
        if (!$shipment) {
            throw new InvalidArgumentException(sprintf('Shipment "%s" was not found.', $shipmentId));
        }

        foreach ($shipment->getStops() as $stop) {
            if ($stop->getId() === $stopId) {
                $stop->setStatus('departed');
            }
        }
        $this->repository->save($shipment);

        foreach ($shipment->getStops() as $stop) {
            if ($stop->getStatus() !== 'departed') {
                return;
            }
        }

        $shipment->setDelivered(true);
        $this->repository->save($shipment);
    }
}
