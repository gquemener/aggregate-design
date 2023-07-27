<?php

declare(strict_types=1);

namespace App\Shipment\Domain;

use LogicException;

final class Stop
{
    private int $id;

    private string $status = 'in_transit';

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function arrive(): void
    {
        if ($this->status === 'arrived') {
            throw new LogicException('Stop is already arrived.');
        }

        $this->status = 'arrived';
    }

    public function depart(): void
    {
        if ($this->status === 'in_transit') {
            throw new LogicException('Stop is not arrived.');
        }

        if ($this->status === 'departed') {
            throw new LogicException('Stop is already departed.');
        }

        $this->status = 'departed';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isDeparted(): bool
    {
        return $this->status === 'departed';
    }
}
