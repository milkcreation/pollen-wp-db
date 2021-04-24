<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Pollen\Database\Drivers\Laravel\Eloquent\AbstractModel as BaseAbstractModel;
use Pollen\WpDb\WpDbProxy;

abstract class AbstractModel extends BaseAbstractModel
{
    use WpDbProxy;
}