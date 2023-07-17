<?php

namespace App\Shipment\Infrastructure\Doctrine\Types;

use App\Shipment\Domain\StopId as DomainStopId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use InvalidArgumentException;

final class StopId extends GuidType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
	if (!$value instanceof DomainStopId) {
	    throw new InvalidArgumentException('Value must be an instance of ' . DomainStopId::class);
	}

	return $value->toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): DomainStopId
    {
        return DomainStopId::fromString($value);
    }

    public function getName(): string
    {
	return 'stop_id';
    }
}
