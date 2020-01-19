<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nsivanoly\LaravelFacebookSdk\SyncableGraphNodeTrait;

class User extends Authenticatable
{
    use Notifiable;
    use SyncableGraphNodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
     * [$graph_node_field_aliases Declare Here All Your Database Column Name With respect to FB Graph Node Field]
     * @var [mix]
     */
    protected static $graph_node_field_aliases = [
        'id' => 'facebook_user_id',
        'email' => 'email',
    ];

    /**
     * user images
     * @return HasMany
     */
    function user_images()
    {
        return $this->hasMany('App\UserImages', 'user_id', 'id');
    }
}
