<?php

namespace App\ProjectOvation\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class ProductId
{
    private function __construct(
        private readonly string $value
    ) {
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function fromString(string $value): self
    {
        if (Uuid::isValid($value)) {
            throw new InvalidArgumentException('Invalid Product ID');
        }

        return new self($value);
    }
}
