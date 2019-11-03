<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Channel extends Model
{
    use SoftDeletes;

    protected $casts = [
        'private' => 'bool',
    ];

    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Scope channel query to public channels only
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('private', true);
    }

    /**
     * Scope channel query to private channels only
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePrivate(Builder $query): Builder
    {
        return $query->where('private', true);
    }
}
