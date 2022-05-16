<?php

namespace App\Models;

use Core\Models\BaseModel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\Like
 *
 * @property int $id
 * @property int $user_id
 * @property int $likeable_id
 * @property string $likeable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Like newModelQuery()
 * @method static Builder|Like newQuery()
 * @method static Builder|Like query()
 * @method static Builder|Like whereCreatedAt($value)
 * @method static Builder|Like whereId($value)
 * @method static Builder|Like whereLikeableId($value)
 * @method static Builder|Like whereLikeableType($value)
 * @method static Builder|Like whereUpdatedAt($value)
 * @method static Builder|Like whereUserId($value)
 * @mixin Eloquent
 * @property-read Model|Eloquent $likeable
 */
class Like extends BaseModel
{
    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    /**
     * @return MorphTo
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
