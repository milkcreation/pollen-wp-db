<?php

declare(strict_types=1);

namespace Pollen\WpDb\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Pollen\WpDb\Eloquent\Casts\DateTimezoneCast;
use Pollen\WpDb\WpDbProxy;

/**
 * @property-read int $ID
 * @property string $user_login
 * @property string $user_pass
 * @property string $user_nicename
 * @property string $user_email
 * @property string $user_url
 * @property Carbon $user_registered
 * @property string $user_activation_key
 * @property bool $user_status
 * @property string $display_name
 * @property bool $spam
 * @property bool $deleted
 * @property Collection $metas
 * @property Collection $posts
 */
class User extends Model
{
    use WpDbProxy;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->connection = $this->wpDb()->mainConnexion();
        $this->primaryKey = 'ID';
        $this->table = 'users';

        $this->casts = array_merge(
            [
                'ID'                  => 'integer',
                'user_login'          => 'string',
                'user_pass'           => 'string',
                'user_nicename'       => 'string',
                'user_email'          => 'string',
                'user_url'            => 'string',
                'user_registered'     => DateTimezoneCast::class,
                'user_activation_key' => 'string',
                'user_status'         => 'boolean',
                'display_name'        => 'string',
                'spam'                => 'boolean',
                'deleted'             => 'boolean',
            ],
            $this->casts
        );

        $this->appends = array_merge(
            static::metaAttributes(),
            $this->appends
        );

        parent::__construct($attributes);
    }

    /**
     * @return array
     */
    public static function metaAttributes(): array
    {
        return [
            'admin_color',
            'comment_shortcuts',
            'community_events_location',
            'description',
            'firstname',
            'lastname',
            'locale',
            'nickname',
            'primary_blog',
            'rich_editing',
            'syntax_highlighting',
            'show_admin_bar_front',
            'show_welcome_panel',
            'source_domain',
            'role',
            'roles',
            'use_ssl',
        ];
    }

    /**
     * @return string|null
     */
    public function getCreatedAtColumn(): ?string
    {
        return 'user_registered';
    }

    /**
     * @return string|null
     */
    public function getUpdatedAtColumn(): ?string
    {
        return null;
    }

    /**
     * @return string
     */
    public function getAdminColorAttribute(): string
    {
        return ($e = $this->metas->where('meta_key', 'admin_color')->first()) ? $e->meta_value : '';
    }

    /**
     * @return bool
     */
    public function getCommentShortcutsAttribute(): bool
    {
        return (($e = $this->metas->where('meta_key', 'comment_shortcuts')->first())) && $e->meta_value;
    }

    /**
     * @return array
     */
    public function getCommunityEventsLocationAttribute(): array
    {
        return ($e = $this->metas->where('meta_key', 'community-events-location')->first()) ? $e->meta_value : [];
    }

    /**
     * @return string
     */
    public function getDescriptionAttribute(): string
    {
        return ($e = $this->metas->where('meta_key', 'description')->first()) ? $e->meta_value : '';
    }

    /**
     * @return string
     */
    public function getFirstnameAttribute(): string
    {
        return ($e = $this->metas->where('meta_key', 'first_name')->first()) ? $e->meta_value : '';
    }

    /**
     * @return string
     */
    public function getLastnameAttribute(): string
    {
        return ($e = $this->metas->where('meta_key', 'last_name')->first()) ? $e->meta_value : '';
    }

    /**
     * @return string
     */
    public function getLocaleAttribute(): string
    {
        return ($e = $this->metas->where('meta_key', 'locale')->first()) ? $e->meta_value : '';
    }

    /**
     * @return string
     */
    public function getNicknameAttribute(): string
    {
        return ($e = $this->metas->where('meta_key', 'nickname')->first()) ? $e->meta_value : '';
    }

    /**
     * @return int
     */
    public function getPrimaryBlogAttribute(): int
    {
        return ($e = $this->metas->where('meta_key', 'primary_blog')->first()) ? (int)$e->meta_value : 0;
    }

    /**
     * @return bool
     */
    public function getRichEditingAttribute(): bool
    {
        return (($e = $this->metas->where('meta_key', 'rich_editing')->first())) && $e->meta_value;
    }

    /**
     * @return string
     */
    public function getRoleAttribute(): string
    {
        if ($roles = array_filter($this->getRolesAttribute())) {
            return key($roles);
        }
        return '';
    }

    /**
     * @return array
     */
    public function getRolesAttribute(): array
    {
        $roleKey = $this->getConnection()->getTablePrefix() . 'capabilities';

        return ($e = $this->metas->where('meta_key', $roleKey)->first()) ? $e->meta_value : [];
    }

    /**
     * @return bool
     */
    public function getSyntaxHighlightingAttribute(): bool
    {
        return (($e = $this->metas->where('meta_key', 'syntax_highlighting')->first())) && $e->meta_value;
    }

    /**
     * @return bool
     */
    public function getShowAdminBarFrontAttribute(): bool
    {
        return (($e = $this->metas->where('meta_key', 'show_admin_bar_front')->first())) && $e->meta_value;
    }

    /**
     * @return bool
     */
    public function getShowWelcomePanelAttribute(): bool
    {
        return (($e = $this->metas->where('meta_key', 'show_welcome_panel')->first())) && $e->meta_value;
    }

    /**
     * @return string
     */
    public function getSourceDomainAttribute(): string
    {
        return ($e = $this->metas->where('meta_key', 'source_domain')->first()) ? $e->meta_value : '';
    }

    /**
     * @return bool
     */
    public function getUseSslAttribute(): bool
    {
        return (($e = $this->metas->where('meta_key', 'use_ssl')->first())) && $e->meta_value;
    }

    /**
     * @return HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(UserMeta::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_author');
    }
}
