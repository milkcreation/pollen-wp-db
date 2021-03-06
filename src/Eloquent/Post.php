<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Pollen\WpDb\Eloquent\Scopes\PostTypeScope;
use Pollen\WpDb\Eloquent\Concerns\MetaAwareTrait;

/**
 * @property-read int $ID
 * @property int $post_author
 * @property Carbon $post_date
 * @property Carbon $post_date_gmt
 * @property string $post_content
 * @property string $post_title
 * @property string $post_excerpt
 * @property string $post_status
 * @property string $comment_status
 * @property string $ping_status
 * @property string $post_password
 * @property string $post_name
 * @property string $to_ping
 * @property string $pinged
 * @property Carbon $post_modified
 * @property Carbon $post_modified_gmt
 * @property string $post_content_filtered
 * @property int $post_parent
 * @property string $guid
 * @property int $menu_order
 * @property string $post_type
 * @property string $post_mime_type
 * @property int $comment_count
 * @property User $author
 * @property Collection $comments
 * @property Collection $metas
 * @property Post $parent
 * @property Collection $taxonomies
 *
 * @method Builder|static published()
 * @method Builder|static status(string|array $status)
 * @method Builder|static type(string|array $type)
 */
class Post extends AbstractModel
{
    use MetaAwareTrait;

    /**
     * Contrainte de type(s) de post.
     * @var string|string[]
     */
    public $postTypeScope = '';

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->primaryKey = 'ID';
        $this->table = 'posts';

        $this->casts = array_merge(
            [
                'ID'                    => 'integer',
                'post_author'           => 'integer',
                'post_date'             => 'datetime',
                'post_date_gmt'         => 'datetime',
                'post_content'          => 'string',
                'post_title'            => 'string',
                'post_excerpt'          => 'string',
                'post_status'           => 'string',
                'comment_status'        => 'string',
                'ping_status'           => 'string',
                'post_password'         => 'string',
                'post_name'             => 'string',
                'to_ping'               => 'boolean',
                'pinged'                => 'boolean',
                'post_modified'         => 'datetime',
                'post_modified_gmt'     => 'datetime',
                'post_content_filtered' => 'string',
                'post_parent'           => 'integer',
                'guid'                  => 'string',
                'menu_order'            => 'integer',
                'post_mime_type'        => 'string',
                'comment_count'         => 'integer',
            ],
            $this->casts
        );

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new PostTypeScope());
    }

    /**
     * @return array
     */
    public function getTermsAttribute(): array
    {
        return $this->taxonomies->groupBy(
            function ($taxonomy) {
                return $taxonomy->taxonomy === 'post_tag' ?
                    'tag' : $taxonomy->taxonomy;
            }
        )->map(
            function ($group) {
                return $group->mapWithKeys(
                    function ($item) {
                        return [$item->term->slug => $item->term->toArray()];
                    }
                );
            }
        )->toArray();
    }

    /**
     * @return HasOne
     */
    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'ID', 'post_author');
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'comment_post_ID');
    }

    /**
     * @return HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(PostMeta::class, 'post_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'post_parent');
    }

    /**
     * @return BelongsToMany
     */
    public function taxonomies(): BelongsToMany
    {
        return $this->belongsToMany(
            TermTaxonomy::class,
            'term_relationships',
            'object_id',
            'term_taxonomy_id'
        );
    }

    /**
     * Limite la port??e de la requ??te au posts publi??s.
     * {@internal Int??gre aussi les publications ?? venir.}
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->where('post_status', 'publish');
            $query->orWhere(function ($query) {
                $query->where('post_status', 'future');
                $query->where('post_date', '<=', Carbon::now()->format('Y-m-d H:i:s'));
            });
        });
    }

    /**
     * Limite la port??e de la requ??te ?? un statut particulier.
     *
     * @param Builder $query
     * @param string|array $status
     *
     * @return Builder
     */
    public function scopeStatus(Builder $query, $status): Builder
    {
        if (is_array($status)) {
            return $query->whereIn('post_status', $status);
        }

        if (is_string($status)) {
            return $query->where('post_status', $status);
        }

        return $query;
    }

    /**
     * Limite la port??e de la requ??te ?? un type de post particulier.
     *
     * @param Builder $query
     * @param string|array $type
     *
     * @return Builder
     */
    public function scopeType(Builder $query, $type): Builder
    {
        if (is_array($type)) {
            return $query->whereIn('post_type', $type);
        }

        if (is_string($type)) {
            return $query->where('post_type', $type);
        }

        return $query;
    }
}
