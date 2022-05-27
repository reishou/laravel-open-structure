<?php

namespace App\Models;

use App\Enums\RelationMap;
use Core\Models\BaseModel;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * \App\Models\User
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $facebook_id
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereFacebookId($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Profile|null $profile
 * @property-read Follow|null $followed
 * @property-read Collection|Follow[] $followers
 * @property-read int|null $followers_count
 * @property-read Collection|Follow[] $following
 * @property-read int|null $following_count
 * @property-read Collection|Post[] $posts
 * @property-read int|null $posts_count
 */
class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Authenticatable;
    use CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'facebook_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * @return HasOne
     */
    public function followed(): HasOne
    {
        return $this->hasOne(Follow::class, 'followable_id')
            ->where('followable_type', RelationMap::USER);
    }

    /**
     * @return HasMany
     */
    public function followers(): HasMany
    {
        return $this->hasMany(Follow::class, 'followable_id')
            ->where('followable_type', RelationMap::USER);
    }

    /**
     * @return HasMany
     */
    public function following(): HasMany
    {
        return $this->hasMany(Follow::class, 'user_id')
            ->where('followable_type', RelationMap::USER);
    }

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
