<?php declare(strict_types=1);

namespace GoldHoarders\Enums;

enum Type
{
    case SAVINGS;
    case CHECKING;

    public static function fromString(string $type): Type
    {
        return match ($type) {
            'SAVINGS' => Type::SAVINGS,
            'CHECKING' => Type::CHECKING,
            default => throw new \Exception('Invalid type'),
        };
    }

    public function toString(): string
    {
        return match ($this) {
            Type::SAVINGS => 'SAVINGS',
            Type::CHECKING => 'CHECKING',
        };
    }
}
