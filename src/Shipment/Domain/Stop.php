<?php

declare(strict_types=1);

namespace App\Shipment\Domain;

final class Stop
{
    private int $id;

    private string $status = 'in_transit';

    private Shipment $shipment;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setShipment(Shipment $shipment): void
    {
        $this->shipment = $shipment;
    }

    public function getShipment(): Shipment
    {
        return $this->shipment;
    }
}
