<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserImages
 * @package App
 */
class UserImages extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'user_images';

    /**
     * Indicates if the model should be timestamped.
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = [];

    /**
     * Images belongs to a user
     * @return BelongsTo
     */
    function user()
    {
        return $this->belongsTo('App\User', 'brand_id');
    }
}
