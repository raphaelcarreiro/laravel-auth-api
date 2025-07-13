<?php

namespace Core\Shared\Application\Dto;

use BackedEnum;
use ReflectionClass;
use ReflectionProperty;
use UnitEnum;

abstract class Dto
{
    public function __construct(array|null $payload)
    {
        $class = $this->getClass();

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
            $this->handleMap($reflectionProperty, $payload);
        }
    }

    private function getClass(): ReflectionClass
    {
        return new ReflectionClass(static::class);
    }

    private function handleMap(ReflectionProperty $reflectionProperty, array $payload): void
    {
        $property = $reflectionProperty->getName();

        if (!array_key_exists($property, $payload)) {
            return;
        }

        $type = $this->getPropertyType($reflectionProperty);

        $this->{$property} = $this->parse($payload[$property], $type);
    }

    private function getPropertyType(ReflectionProperty $property): string
    {
        return $property->getType()->getName();
    }

    private function parse($value, string $type)
    {
        if (is_null($value)) {
            return null;
        }

        if (class_exists($type)) {
            $class = new ReflectionClass($type);

            if ($class->isEnum() && is_scalar($value)) {
                return $type::from($value);
            }

            if ($class->isEnum()) {
                return $value;
            }

            if ($value instanceof $type) {
                return $value;
            }

            return new $type($value);
        }

        settype($value, $type);

        return $value;
    }

    public function toArray(): array
    {
        return array_map(function ($value) {
            return $this->serializeValue($value);
        }, get_object_vars($this));
    }

    private function serializeValue(mixed $value): mixed
    {
        if ($value instanceof UnitEnum) {
            return $value instanceof BackedEnum ? $value->value : $value->name;
        }

        if ($value instanceof Dto) {
            return $value->toArray();
        }

        if (is_array($value)) {
            return array_map(fn($item) => $this->serializeValue($item), $value);
        }

        if (is_object($value) && method_exists($value, '__toString')) {
            return (string) $value;
        }

        return $value;
    }
}
