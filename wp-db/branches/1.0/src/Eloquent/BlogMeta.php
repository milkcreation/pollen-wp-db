<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pollen\WpDb\Eloquent\Casts\TypeCast;

/**
 * @property-read int $meta_id
 * @property int $blog_id
 * @property string $meta_key
 * @property mixed $meta_value
 * @property Blog $blog
 */
class BlogMeta extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->primaryKey = 'meta_id';
        $this->table = 'blogmeta';
        $this->timestamps = false;

        $this->casts = array_merge(
            [
                'meta_id'    => 'integer',
                'blog_id'    => 'integer',
                'meta_key'   => 'string',
                'meta_value' => TypeCast::class,
            ],
            $this->casts
        );

        parent::__construct($attributes);
    }

    /**
     * @return BelongsTo
     */
    public function blog(): BelongsTo
    {
        return $this->BelongsTo(Blog::class, 'blog_id');
    }
}