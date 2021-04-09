<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent\Casts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Pollen\Support\Str;

class TypeCast implements CastsAttributes
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     *
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        if (is_numeric($value)) {
            return (int)$value;
        }

        if ($value === 'true' || $value === 'false' || $value === 'yes' || $value === 'no') {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        return Str::unserialize($value);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     *
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}