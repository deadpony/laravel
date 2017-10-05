<?php
namespace App\Convention\ValueObjects\Identity\Doctrine;

use App\Convention\ValueObjects\Identity\Identity;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Psr\Log\InvalidArgumentException;

class IdentityType extends Type
{
    /**
     *
     */
    const NAME = 'identity';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'IDENTITY';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof Identity) {
            return $value;
        }

        try {
            $uuid = new Identity($value);
        } catch (InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $uuid;
    }
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Identity) {
            return (string) $value;
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }
}