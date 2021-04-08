<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
        $this->casts = [
            'blog_id'      => 'integer',
            'site_id'      => 'integer',
            'domain'       => 'string',
            'path'         => 'string',
            'registered'   => 'datetime',
            'last_updated' => 'datetime',
            'public'       => 'boolean',
            'archives'     => 'boolean',
            'mature'       => 'boolean',
            'spam'         => 'boolean',
            'deleted'      => 'boolean',
            'lang_id'      => 'integer',
        ];

        parent::__construct($attributes);
    }
}