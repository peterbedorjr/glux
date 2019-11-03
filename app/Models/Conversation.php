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
     * @param Collection $users
     * @return bool|mixed
     */
    public static function exists(Collection $users)
    {
        /* @var Collection $ids */
        $ids = $users->map(function($user) {
            return $user->id;
        });

        $query = DB::table('conversation_user AS c1')
            ->select('c2.conversation_id AS id')
            ->distinct();

        for ($i = 0; $i < $ids->count(); $i++) {
            $id = $ids[$i];

            $query->join('conversation_user AS c' . ($i + 2), function($join) use ($id, $i) {
                /* @var \Illuminate\Database\Query\JoinClause $join */
                $join->where('c' . ($i + 2) . '.user_id', '=', $id);
            });
        }

        $result = $query->first();

        if (! empty($result)) {
            return $result->id;
        }

        return false;
    }

    //public static function exists(User $userOne, User $userTwo)
    //{
    //    $conversation = DB::table('conversation_user AS c1')
    //            ->select('c2.conversation_id AS id')
    //            ->distinct()
    //            ->join('conversation_user AS c2', function($join) use ($userOne, $userTwo) {
    //                /* @var \Illuminate\Database\Query\JoinClause $join */
    //                $join->where('c1.user_id', '=', $userOne->id)
    //                    ->where('c2.user_id', '=', $userTwo->id);
    //            })->first();
    //
    //    if (! empty($conversation)) {
    //        return self::find($conversation->id);
    //    }
    //
    //    return false;
    //}
}
