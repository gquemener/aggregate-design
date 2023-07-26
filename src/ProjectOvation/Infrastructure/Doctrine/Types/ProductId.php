<?php declare(strict_types=1);

namespace App\ProjectOvation\Infrastructure\Doctrine\Types;

use App\ProjectOvation\Domain\ProductId as DomainProductId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use InvalidArgumentException;

final class ProductId extends GuidType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (!$value instanceof DomainProductId) {
            throw new InvalidArgumentException('Value must be an instance of ' . DomainProductId::class);
        }

        return $value->toString();
    }

    /**
     * Converts a value from its database representation to its PHP representation
     * of this type.
     *
     * @param mixed            $value    The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return mixed The PHP representation of the value.
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): DomainProductId
    {
        return DomainProductId::fromString($value);
    }

    public function getName(): string
    {
        return 'product_id';
    }
}
