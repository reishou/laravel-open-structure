<?php

namespace App\Models;

use Core\Models\BaseModel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * \App\Models\PostImage
 *
 * @property int $id
 * @property int $post_id
 * @property string $path
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string|null $url
 * @method static Builder|PostImage newModelQuery()
 * @method static Builder|PostImage newQuery()
 * @method static Builder|PostImage query()
 * @method static Builder|PostImage whereCreatedAt($value)
 * @method static Builder|PostImage whereDeletedAt($value)
 * @method static Builder|PostImage whereId($value)
 * @method static Builder|PostImage wherePath($value)
 * @method static Builder|PostImage wherePostId($value)
 * @method static Builder|PostImage whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Query\Builder|PostImage onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|PostImage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PostImage withoutTrashed()
 * @property int $width
 * @property int $height
 * @method static Builder|PostImage whereHeight($value)
 * @method static Builder|PostImage whereWidth($value)
 * @property-read Post|null $post
 */
class PostImage extends BaseModel
{
    use SoftDeletes;

    protected $table = 'post_images';

    protected $fillable = [
        'post_id',
        'path',
        'width',
        'height',
    ];

    /**
     * @return string|null
     */
    public function getUrlAttribute(): ?string
    {
        if (!$this->path) {
            return null;
        }

        return Storage::temporaryUrl($this->path, now()->addMinutes(10));
    }

    /**
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
