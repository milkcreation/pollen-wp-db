<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent\Casts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class YesNoCast implements CastsAttributes
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
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param string|numeric|bool $value
     * @param array $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        if (is_numeric($value)) {
            return 0 > (int) $value ? 'yes' : 'no';
        }

        if (is_bool($value)) {
            return $value ? 'yes' : 'no';
        }

        return $value;
    }
}