<?php

declare(strict_types=1);

namespace App\Shipment\Application;

use App\Shipment\Domain\Shipment;
use App\Shipment\Domain\ShipmentRepository;
use App\Shipment\Domain\Stop;
use App\Shipment\Domain\StopRepository;
use InvalidArgumentException;
use LogicException;

final class ShipmentService
{
    public function __construct(
        private readonly ShipmentRepository $shipmentRepository,
        private readonly StopRepository $stopRepository,
    ) {
    }

    /**
     * @param array<Stop> $stops
     */
    public function scheduleShipment(int $id, array $stops): void {
        $shipment = new Shipment($id);
        foreach ($stops as $stop) {
            $this->stopRepository->save($stop);
            $shipment->addStop($stop);
        }

        $this->shipmentRepository->save($shipment);
    }

    public function arriveAtStop(int $stopId): void
    {
        $stop = $this->stopRepository->find($stopId);
        if (!$stop) {
            throw new InvalidArgumentException(sprintf('Stop "%s" was not found.', $stopId));
        }

        $shipment = $stop->getShipment();
        $previousStop = null;
        foreach ($shipment->getStops() as $shipmentStop) {
            if ($shipmentStop->getId() === $stopId) {
                if ($previousStop && $previousStop->getStatus() !== 'departed') {
                    throw new LogicException(sprintf('Cannot arrive at stop %d before departing stop %d.', $stopId, $previousStop->getId()));
                }
            }
            $previousStop = $shipmentStop;
        }
        $stop->setStatus('arrived');

        $this->stopRepository->save($stop);
    }

    public function departFromStop(int $stopId): void
    {
        $stop = $this->stopRepository->find($stopId);
        if (!$stop) {
            throw new InvalidArgumentException(sprintf('Stop "%s" was not found.', $stopId));
        }

        $stop->setStatus('departed');

        $this->stopRepository->save($stop);

        $shipment = $stop->getShipment();
        foreach ($shipment->getStops() as $shipmentStop) {
            if ($shipmentStop->getStatus() !== 'departed') {
                return;
            }
        }

        $shipment->setDelivered(true);

        $this->shipmentRepository->save($shipment);
    }
}
