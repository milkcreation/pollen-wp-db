<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pollen\Database\Drivers\Laravel\Eloquent\Casts\TypeCast;
use Pollen\WpDb\WpDbProxy;

/**
 * @property-read int $meta_id
 * @property int $comment_id
 * @property string $meta_key
 * @property mixed $meta_value
 * @property Comment $comment
 */
class CommentMeta extends AbstractModel
{
    use WpDbProxy;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->primaryKey = 'meta_id';
        $this->table = 'commentmeta';
        $this->timestamps = false;

        $this->casts = array_merge(
            [
                'meta_id'    => 'integer',
                'comment_id' => 'integer',
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
    public function comment(): BelongsTo
    {
        return $this->BelongsTo(Comment::class, 'comment_id');
    }
}