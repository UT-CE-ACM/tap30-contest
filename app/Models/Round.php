<?php

namespace App\Models;

use DateTime;

/**
 * @property integer id
 * @property integer number
 * @property boolean is_finished
 * @property TestCase[] test_cases
 * @property Record[] records
 * @property Run[] runs
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * Class Round
 * @package App\Models
 */
class Round extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'is_finished'
    ];

    public static $numOfRounds = 6;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function test_cases(){
        return $this->hasMany('\\App\\Models\\TestCase', 'round_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function records(){
        return $this->hasMany('\\App\\Models\\Record', 'round_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function runs(){
        return $this->hasMany('\\App\\Models\\Run', 'round_id');
    }
}
