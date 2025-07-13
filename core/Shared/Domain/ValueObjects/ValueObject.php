<?php

namespace Core\Shared\Domain\ValueObjects;

abstract class ValueObject
{
    public abstract function __toString(): string;

    public abstract function getValue(): mixed;
}
