<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Pollen\WpDb\Eloquent\Casts\DateTimezoneCast;

/**
 * @property-read int $blog_id
 * @property-read int $site_id
 * @property string $domain
 * @property string $path
 * @property Carbon $registered
 * @property Carbon $last_updated
 * @property bool $public
 * @property bool $archived
 * @property bool $mature
 * @property bool $spam
 * @property bool $deleted
 * @property int $lang_id
 * @property Collection $metas
 */
class Blog extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->primaryKey = 'blog_id';
        $this->table = 'blogs';

        $this->casts = array_merge(
            [
                'blog_id'      => 'integer',
                'site_id'      => 'integer',
                'domain'       => 'string',
                'path'         => 'string',
                'registered'   => DateTimezoneCast::class,
                'last_updated' => DateTimezoneCast::class,
                'public'       => 'boolean',
                'archives'     => 'boolean',
                'mature'       => 'boolean',
                'spam'         => 'boolean',
                'deleted'      => 'boolean',
                'lang_id'      => 'integer',
            ],
            $this->casts
        );

        parent::__construct($attributes);
    }

    /**
     * @return string|null
     */
    public function getCreatedAtColumn(): ?string
    {
        return 'registered';
    }

    /**
     * @return string|null
     */
    public function getUpdatedAtColumn(): ?string
    {
        return 'last_updated';
    }

    /**
     * @return HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(BlogMeta::class, 'blog_id');
    }
}