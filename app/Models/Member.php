<?php

namespace App\Models;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string name
 * @property string email
 * @property integer user_id
 * @property User team
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * Class Member
 * @package App\Models
 */
class Member extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(){
        return $this->belongsTo("\\App\\Models\\User", "user_id");
    }
}
