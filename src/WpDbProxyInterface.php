<?php

declare(strict_types=1);

namespace Pollen\WpDb;

interface WpDbProxyInterface
{
    /**
     * Instance du gestionnaire de base de données Wordpress.
     *
     * @return WpDbProxyInterface
     */
    public function wpDb(): WpDbProxyInterface;

    /**
     * Définition du gestionnaire de base de données Wordpress.
     *
     * @param WpDbProxyInterface $wpDb
     *
     * @return void
     */
    public function setWpDb(WpDbProxyInterface $wpDb): void;
}