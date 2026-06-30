<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionProperty;

abstract class Data
{
    abstract public static function getModel(): string;

    public function toModel(): Model
    {
        $model = $this->resolveModel(static::getModel());
        $model->fill($this->toModelAttributes());

        return $model;
    }

    protected function resolveModel(string $modelClass): Model
    {
        $key = $this->getKey();

        if ($key !== null) {
            return $modelClass::query()->findOrFail($key);
        }

        return new $modelClass;
    }

    protected function getKey(): string|int|null
    {
        if (!property_exists($this, 'id')) {
            return null;
        }

        return $this->id;
    }

    /**
     * @return array<string, mixed>
     */
    protected function toModelAttributes(): array
    {
        $attributes = [];

        foreach (new ReflectionClass($this)->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->getName();

            if (in_array($name, $this->exceptFromModel(), true)) {
                continue;
            }

            $attributes[Str::snake($name)] = $property->getValue($this);
        }

        return $attributes;
    }

    /**
     * @return list<string>
     */
    protected function exceptFromModel(): array
    {
        return ['id'];
    }
}
