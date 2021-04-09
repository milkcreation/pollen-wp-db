<?php

declare(strict_types=1);

namespace Pollen\WpDb;

use Pollen\Support\StaticProxy;
use RuntimeException;

/**
 * @see \Pollen\WpDb\WpDbProxyInterface
 */
trait WpDbProxy
{
    /**
     * Instance du gestionnaire de base de données Wordpress.
     * @var WpDbInterface
     */
    private $wpDb;

    /**
     * Instance du gestionnaire de base de données Wordpress.
     *
     * @return WpDbInterface
     */
    public function wpDb(): WpDbInterface
    {
        if ($this->wpDb === null) {
            try {
                $this->wpDb = WpDb::getInstance();
            } catch (RuntimeException $e) {
                $this->wpDb = StaticProxy::getProxyInstance(
                    WpDbInterface::class,
                    WpDb::class,
                    method_exists($this, 'getContainer') ? $this->getContainer() : null
                );
            }
        }

        return $this->wpDb;
    }

    /**
     * Définition du gestionnaire de base de données Wordpress.
     *
     * @param WpDbInterface $wpDb
     *
     * @return void
     */
    public function setWpDb(WpDbInterface $wpDb): void
    {
        $this->wpDb = $wpDb;
    }
}