<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent\Casts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Pollen\Support\Arr;
use Pollen\Support\Str;

class SerializeCast implements CastsAttributes
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     *
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        return Str::unserialize($value);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param array $value
     * @param array $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return Arr::serialize($value);
    }
}