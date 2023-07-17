<?php

namespace App\ProjectOvation\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Ramsey\Uuid\Uuid;

#[Embeddable]
final class TenantId
{
    private  function __construct(
        #[Column]
        private readonly string $value
    ) {}

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }
}
