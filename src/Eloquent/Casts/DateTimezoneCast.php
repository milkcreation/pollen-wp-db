<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent\Casts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Pollen\Support\Env;

class DateTimezoneCast implements CastsAttributes
{
    /**
     * @param Model $model
     * @param string $key
     * @param string $value
     * @param array $attributes
     *
     * @return string
     */
    public function get($model, $key, $value, $attributes)
    {
        if ($value === '0000-00-00 00:00:00') {
            return $value;
        }

        return Carbon::createFromTimestamp(strtotime($value))->setTimezone(Env::get('APP_TIMEZONE', 'UTC'))
            ->toDateTimeString();
    }

    /**
     * @param Model $model
     * @param string $key
     * @param string $value
     * @param array $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        if ($value === '0000-00-00 00:00:00') {
            return $value;
        }

        return Carbon::createFromTimestamp(strtotime($value))->setTimezone(Env::get('APP_TIMEZONE', 'UTC'))
            ->toDateTimeString();
    }
}