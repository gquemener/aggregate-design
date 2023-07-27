<?php declare(strict_types=1);

namespace App\Shipment\Domain;

interface StopRepository
{
    public function save(Stop $shipment): void; 

    public function find(int $id): ?Stop;
}
