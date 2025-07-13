<?php

namespace Core\Shared\Domain\ValueObjects;

use Core\Shared\Domain\Exceptions\DomainException;
use Illuminate\Support\Str;

class Uuid extends ValueObject
{
    private string $value;

    public function __construct(string|null $value = null)
    {
        if (!$value) {
            $this->value = Str::uuid()->toString();
            return;
        }

        $this->validate($value);
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @throws DomainException
     */
    private function validate(string $id): void
    {
        if (!Str::isUuid($id)) {
            throw new DomainException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
