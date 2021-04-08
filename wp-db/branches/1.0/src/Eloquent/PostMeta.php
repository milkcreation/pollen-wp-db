<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pollen\WpDb\Eloquent\Casts\TypeCast;

/**
 * @property-read int $meta_id
 * @property int $post_id
 * @property string $meta_key
 * @property mixed $meta_value
 * @property Post $post
 */
class PostMeta extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->primaryKey = 'meta_id';
        $this->table = 'postmeta';
        $this->timestamps = false;

        $this->casts = array_merge(
            [
                'meta_id'    => 'integer',
                'post_id'    => 'integer',
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
    public function post(): BelongsTo
    {
        return $this->BelongsTo(Post::class, 'post_id');
    }
}