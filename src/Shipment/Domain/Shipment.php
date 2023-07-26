<?php

declare(strict_types=1);

namespace App\Shipment\Domain;

final class Shipment
{
    private int $id;

    /** @var array<Stop> */
    private array $stops;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->stops = [];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function addStop(Stop $stop): void
    {
        $this->stops[] = $stop;
        $stop->setShipment($this);
    }

    public function removeStop(Stop $stop): void
    {
        foreach ($this->stops as $key => $existingStop) {
            if ($existingStop->getId() === $stop->getId()) {
                unset($this->stops[$key]);
            }
        }
    }
}
