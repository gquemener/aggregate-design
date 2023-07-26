<?php declare(strict_types=1);

namespace App\Shipment\Domain;

interface ShipmentRepository
{
    public function save(Shipment $shipment): void; 

    public function find(int $id): ?Shipment;
}
