<?php

declare(strict_types=1);

namespace Pollen\WpDb;

use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ConfigBagAwareTraitInterface;
use Pollen\Support\Proxy\ContainerProxyInterface;
use Pollen\Support\Proxy\DbProxyInterface;

interface WpDbInterface extends
    BootableTraitInterface,
    ConfigBagAwareTraitInterface,
    ContainerProxyInterface,
    DbProxyInterface
{
    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): WpDbInterface;

    /**
     * Récupération du nom de la connexion à la base de données d'un site du réseau.
     *
     * @param int $id
     *
     * @return string
     */
    public function blogConnection(int $id = 1): string;

    /**
     * Récupération des identifiants de qualification des sites du réseau.
     *
     * @return int[]|array
     */
    public function blogIds(): array;

    /**
     * Récupération du nom de la connexion à la base de données principale.
     *
     * @return string
     */
    public function mainConnexion(): string;

    /**
     * Vérification d'existence de la base de données Wordpress.
     *
     * @return bool
     */
    public function hasGlobalWpDb(): bool;
}
