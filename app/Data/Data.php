<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Database\Eloquent\Model;

abstract class Data
{
    abstract public static function getModel(): string;

    abstract public function toModel(): Model;
}
