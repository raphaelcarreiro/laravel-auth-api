<?php

namespace Core\Shared\Domain;

use Core\Shared\Domain\Exceptions\DomainException;
use Exception;

abstract class Entity
{
    abstract public function toArray(): array;

    abstract public static function create(array $payload): self;

    /**
     * @throws Exception
     */
    public function __get($property)
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        $className = get_class($this);

        throw new DomainException("Property {$property} not found in class {$className}");
    }
}
