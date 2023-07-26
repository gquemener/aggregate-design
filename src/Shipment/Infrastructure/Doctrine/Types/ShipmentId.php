<?php

namespace App\Shipment\Infrastructure\Doctrine\Types;

use App\Shipment\Domain\ShipmentId as DomainShipmentId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use InvalidArgumentException;

final class ShipmentId extends GuidType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (!$value instanceof DomainShipmentId) {
            throw new InvalidArgumentException('Value must be an instance of ' . DomainShipmentId::class);
        }

        return $value->toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): DomainShipmentId
    {
        return DomainShipmentId::fromString($value);
    }

    public function getName(): string
    {
        return 'shipment_id';
    }
}
