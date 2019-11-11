<?php

namespace App\Models;

use App\Models\Pivots\ConversationUser;
use App\Notifications\VerifyEmail;
use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject //, MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar',
    ];

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getAvatarAttribute()
    {
        return 'https://i.pravatar.cc/150?u=' . md5(strtolower($this->email));
    }

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function updateCurrentConversationId($id)
    {
        $this->current_conversation_id = $id;
        $this->save();

        return $this;
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }

    public function channels()
    {
        return $this->hasManyThrough(
            Channel::class,
            ConversationUser::class,
            'user_id',
            'conversation_id',
            null,
            'conversation_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Start a conversation with another user
     *
     * @param Collection $users
     * @return Conversation|bool
     */
    public function startConversationWith(Collection $users)
    {
        if ($conversation = Conversation::exists($this, $users)) {
            return $conversation;
        }

        $conversation = Conversation::create();
        $conversation->users()->attach($users);

        return $conversation;
    }
}
