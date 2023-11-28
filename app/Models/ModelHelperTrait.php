<?php

declare(strict_types=1);

namespace App\Models;

trait ModelHelperTrait
{
    public static function getFillableAttributes(): array
    {
        return (new static)->getFillable();
    }
}
