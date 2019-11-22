<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Topic
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic latestFirst()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic oldestFirst()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereUserId($value)
 * @mixin \Eloquent
 */
class Topic extends Model
{
    use Orderable;

    protected $fillable = ['title'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->oldestFirst();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
