<?php

namespace App\Models;

use Core\Models\BaseModel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\Follow
 *
 * @property int $id
 * @property int $user_id
 * @property int $followable_id
 * @property string $followable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Follow newModelQuery()
 * @method static Builder|Follow newQuery()
 * @method static Builder|Follow query()
 * @method static Builder|Follow whereCreatedAt($value)
 * @method static Builder|Follow whereFollowableId($value)
 * @method static Builder|Follow whereFollowableType($value)
 * @method static Builder|Follow whereId($value)
 * @method static Builder|Follow whereUpdatedAt($value)
 * @method static Builder|Follow whereUserId($value)
 * @mixin Eloquent
 * @property-read Model|Eloquent $followable
 * @property-read User|null $user
 */
class Follow extends BaseModel
{
    protected $table = 'follows';

    protected $fillable = [
        'user_id',
        'followable_id',
        'followable_type',
    ];

    /**
     * @return MorphTo
     */
    public function followable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
