<?php

namespace App\Models;

use Core\Models\BaseModel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * \App\Models\Profile
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $nickname
 * @property string|null $avatar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Profile newModelQuery()
 * @method static Builder|Profile newQuery()
 * @method static Builder|Profile query()
 * @method static Builder|Profile whereAvatar($value)
 * @method static Builder|Profile whereCreatedAt($value)
 * @method static Builder|Profile whereId($value)
 * @method static Builder|Profile whereName($value)
 * @method static Builder|Profile whereNickname($value)
 * @method static Builder|Profile whereUpdatedAt($value)
 * @method static Builder|Profile whereUserId($value)
 * @mixin Eloquent
 * @property-read string|null $avatar_url
 * @property string|null $description
 * @method static Builder|Profile whereDescription($value)
 */
class Profile extends BaseModel
{
    protected $table = 'profiles';

    protected $fillable = [
        'id',
        'name',
        'nickname',
        'avatar',
    ];

    /**
     * @return string|null
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar) {
            return null;
        }

        return Storage::temporaryUrl($this->avatar, now()->addMinutes(10));
    }
}
