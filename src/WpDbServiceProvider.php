<?php

declare(strict_types=1);

namespace Pollen\WpDb;

use Pollen\Container\BootableServiceProvider;

class WpDbServiceProvider extends BootableServiceProvider
{
    /**
     * @var string[]
     */
    protected $provides = [
        WpDbInterface::class,
    ];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(
            WpDbInterface::class,
            function () {
                return new WpDb([], $this->getContainer());
            }
        );
    }
}
