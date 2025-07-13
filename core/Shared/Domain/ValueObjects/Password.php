<?php

namespace Core\Shared\Domain\ValueObjects;

use Illuminate\Support\Facades\Hash;

class Password extends ValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        if (Hash::isHashed($value)) {
            $this->value = $value;
            return;
        }

        $this->value = Hash::make($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function check(string $password): bool
    {
        return Hash::check($password, $this->value);
    }
}
