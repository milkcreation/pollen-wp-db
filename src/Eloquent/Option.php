<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Pollen\WpDb\Eloquent\Casts\TypeCast;
use Pollen\WpDb\Eloquent\Casts\YesNoCast;

/**
 * @property-read int $option_id
 * @property string $option_name
 * @property mixed $option_value
 * @property bool $autoload
 */
class Option extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->primaryKey = 'option_id';
        $this->table = 'options';
        $this->timestamps = false;

        $this->casts = array_merge(
            [
                'option_id'    => 'integer',
                'option_name'  => 'string',
                'option_value' => TypeCast::class,
                'autoload'     => YesNoCast::class,
            ],
            $this->casts
        );

        parent::__construct($attributes);
    }
}