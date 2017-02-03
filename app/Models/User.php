<?php

namespace App\Models;

use Faker\Provider\DateTime;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property integer id
 * @property string name
 * @property string username
 * @property string password
 * @property string remember_token
 * @property boolean is_admin
 * @property boolean has_lost
 * @property Record[] records
 * @property Member[] members
 * @property Submit[] submits
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'is_admin', 'has_lost'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members(){
        return $this->hasMany("\\App\\Models\\Member", "user_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submits(){
        return $this->hasMany("\\App\\Models\\Submit","user_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function records(){
        return $this->belongsToMany("\\App\\Models\\Record", "record_user", "user_id", "record_id");
    }

    /**
     * Scope a query to only include in competition users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAllowed($query){
        return $query->whereIsAdmin(false)->whereHasLost(false);
    }
}
