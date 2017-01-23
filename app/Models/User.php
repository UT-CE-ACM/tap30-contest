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
        'name', 'username', 'password', 'is_admin',
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
}
