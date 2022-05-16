<?php

namespace App\Models;

use App\Enums\RelationMap;
use Core\Models\BaseModel;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\PostComment
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $content
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment newQuery()
 * @method static Builder|PostComment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereUserId($value)
 * @method static Builder|PostComment withTrashed()
 * @method static Builder|PostComment withoutTrashed()
 * @mixin Eloquent
 * @property-read User|null $user
 * @property-read Like|null $liked
 * @property-read Collection|Like[] $likes
 * @property-read int|null $likes_count
 */
class PostComment extends BaseModel
{
    use SoftDeletes;

    protected $table = 'post_comments';

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function liked(): HasOne
    {
        return $this->hasOne(Like::class, 'likeable_id')
            ->where('likeable_type', RelationMap::POST_COMMENT);
    }

    /**
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'likeable_id')
            ->where('likeable_type', RelationMap::POST_COMMENT);
    }
}
