<?php

declare(strict_types=1);

namespace App\Shipment\Domain;

use InvalidArgumentException;

final class Shipment
{
    private int $id;

    /** @var array<Stop> */
    private array $stops;

    /**
     * @param array<Stop> $stops
     */
    private function __construct(int $id, array $stops)
    {
        $this->id = $id;
        $this->stops = $stops;
    }

    /**
     * @param array<Stop> $stops
     */
    public static function schedule(int $id, array $stops): self
    {
        return new self($id, $stops);
    }

    public function arrive(int $stopId): void
    {
        $previousStop = null;
        foreach ($this->stops as $stop) {
            if ($previousStop instanceof Stop && !$previousStop->isDeparted()) {
                throw new SkippedStopException();
            }

            if ($stop->getId() === $stopId) {
                $stop->arrive();

                return;
            }
            $previousStop = $stop;
        }

        throw new InvalidArgumentException('Stop does not exist.');
    }

    public function depart(int $stopId): void
    {
        foreach ($this->stops as $stop) {
            if ($stop->getId() === $stopId) {
                $stop->depart();

                return;
            }
        }

        throw new InvalidArgumentException('Stop does not exist.');
    }

    public function getId(): int
    {
        return $this->id;
    }
 
    public function isDelivered(): bool
    {
        foreach ($this->stops as $stop) {
            if (!$stop->isDeparted()) {
                return false;
            }
        }

        return true;
    }
}
