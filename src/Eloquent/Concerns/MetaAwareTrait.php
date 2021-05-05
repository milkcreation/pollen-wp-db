<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent\Concerns;

trait MetaAwareTrait
{
    /**
     * Récupération de la valeur d'une metadonnée.
     *
     * @param string $meta_key
     * @param mixed $default
     * @param bool $single
     *
     * @return mixed
     */
    public function getMeta(string $meta_key, $default = null, bool $single = false)
    {
        $query = $this->metas()->where('meta_key', $meta_key);

        if ($single === true) {
            if ($meta = $query->first()) {
                return $meta->getAttribute('meta_value');
            }
            return $default;
        }

        $metas = [];
        $collection = $query->get();
        foreach ($collection as $meta) {
            $metas[$meta->getKey()] = $meta->getAttribute('meta_value');
        }

        return !empty($metas) ? : $default;
    }

    /**
     * Récupération de la valeur unique d'une metadonnée.
     *
     * @param string $meta_key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getMetaSingle(string $meta_key, $default = null)
    {
        return $this->getMeta($meta_key, $default, true);
    }

    /**
     * Récupération de la valeur multiple d'une metadonnée.
     *
     * @param string $meta_key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getMetaMulti(string $meta_key, $default = null)
    {
        return $this->getMeta($meta_key, $default);
    }
}
