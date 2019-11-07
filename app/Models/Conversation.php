<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Conversation extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Check if a conversation exists between a collection of users
     *
     * @param User $user
     * @param Collection $users
     * @return bool|mixed
     */
    public static function exists(User $user, Collection $users)
    {
        /* @var Collection $ids */
        $ids = $users->map(function($user) {
            return $user->id;
        });

        return $user->conversations()
            ->with('users')
            ->get()
            ->map(function($conversation) use ($ids) {
                /* @var Collection $userIds */
                $userIds = $conversation->users->map(function($user) {
                    return $user->id;
                });

                if (
                    $userIds->count() === $ids->count()
                    && $userIds->sort()->values()->all() === $ids->sort()->values()->all()
                ) {
                    return $conversation;
                }
            })->filter(function($val) {
                return $val;
            })->first();
    }
}
