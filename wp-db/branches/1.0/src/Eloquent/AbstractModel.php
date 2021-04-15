<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Pollen\WpDb\WpDbProxy;

class AbstractModel extends Model
{
    use WpDbProxy;

    /**
     * {@inheritDoc}
     *
     * @return Builder|$this
     */
    public static function on($connection = null)
    {
        return parent::on($connection);
    }
}