<?php

namespace App\Models;

use App\Enums\RelationMap;
use Core\Models\BaseModel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * \App\Models\Post
 *
 * @property int $id
 * @property int $user_id
 * @property string $content
 * @property string|null $caught_fish_at
 * @property string|null $fish_species
 * @property string|null $fish_size
 * @property int|null $total_fishes
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereCaughtFishAt($value)
 * @method static Builder|Post whereContent($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereFishSize($value)
 * @method static Builder|Post whereFishSpecies($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereLatitude($value)
 * @method static Builder|Post whereLocation($value)
 * @method static Builder|Post whereLongitude($value)
 * @method static Builder|Post whereTotalFishes($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post whereUserId($value)
 * @mixin Eloquent
 * @property-read Collection|PostImage[] $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Query\Builder|Post onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Post withoutTrashed()
 * @property Carbon|null $deleted_at
 * @property-read Collection|PostComment[] $comments
 * @property-read int|null $comments_count
 * @property-read Like|null $liked
 * @method static Builder|Post whereDeletedAt($value)
 * @property-read Collection|Like[] $likes
 * @property-read int|null $likes_count
 * @property-read User|null $user
 * @property-read Collection|PostComment[] $topComments
 * @property-read int|null $top_comments_count
 */
class Post extends BaseModel
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'content',
        'caught_fish_at',
        'fish_species',
        'fish_size',
        'total_fishes',
        'latitude',
        'longitude',
        'location',
    ];

    protected $dates = [
        'caught_fish_at',
    ];

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class);
    }

    /**
     * @return HasOne
     */
    public function liked(): HasOne
    {
        return $this->hasOne(Like::class, 'likeable_id')
            ->where('likeable_type', RelationMap::POST);
    }

    /**
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'likeable_id')
            ->where('likeable_type', RelationMap::POST);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function topComments(): HasMany
    {
        return $this->hasMany(PostComment::class)
            ->orderByDesc('id')
            ->limit(2);
    }
}
