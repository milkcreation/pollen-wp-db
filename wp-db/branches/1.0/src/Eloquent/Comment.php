<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Pollen\WpDb\Eloquent\Casts\DateTimezoneCast;

/**
 * @property-read int $comment_ID
 * @property int $comment_post_ID
 * @property string $comment_author
 * @property string $comment_author_email
 * @property string $comment_author_url
 * @property string $comment_author_IP
 * @property Carbon $comment_date
 * @property Carbon $comment_date_gmt
 * @property bool $comment_karma
 * @property bool $comment_approved
 * @property string $comment_agent
 * @property string $comment_type
 * @property int $comment_parent
 * @property int $user_id
 * @property Collection $metas
 * @property Post $post
 * @property User $user
 */
class Comment extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->primaryKey = 'comment_ID';
        $this->table = 'comments';

        $this->casts = array_merge(
            [
                'comment_ID'           => 'integer',
                'comment_post_ID'      => 'integer',
                'comment_author'       => 'string',
                'comment_author_email' => 'string',
                'comment_author_url'   => 'string',
                'comment_author_IP'    => 'string',
                'comment_date'         => DateTimezoneCast::class,
                'comment_date_gmt'     => DateTimezoneCast::class,
                'comment_karma'        => 'boolean',
                'comment_approved'     => 'boolean',
                'comment_agent'        => 'string',
                'comment_type'         => 'string',
                'comment_parent'       => 'integer',
                'user_id'              => 'integer',
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
        return 'comment_date';
    }

    /**
     * @return string|null
     */
    public function getUpdatedAtColumn(): ?string
    {
        return null;
    }

    /**
     * @return HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(CommentMeta::class, 'comment_id');
    }

    /**
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'comment_post_ID');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}