<?php

namespace Core\Shared\Domain\Traits;

use DateTime;
use DateTimeInterface;

trait TimestampsTrait
{
    public DateTime $createdAt;
    public DateTime $updatedAt;

    public function createdAtIsoString(): string
    {
        return $this->createdAt->format(DateTimeInterface::ATOM);
    }

    public function updatedAtIsoString(): string
    {
        return $this->updatedAt->format(DateTimeInterface::ATOM);
    }
}
