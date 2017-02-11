<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Facades\Auth;

/**
 * @property integer id
 * @property integer round_id
 * @property Round round
 * @property User[] teams
 * @property integer winner_id
 * @property User winner
 * @property integer first_record_id
 * @property integer second_record_id
 * @property Record first_record
 * @property Record second_record
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * Class Record
 * @package App\Models
 */
class Record extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'round_id', 'winner_id', 'first_record_id', 'second_record_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams(){
        return $this->belongsToMany('\\App\\Models\\User', 'record_user', 'record_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function winner(){
        return $this->belongsTo('\\App\\Models\\User', 'winner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function first_record(){
        return $this->belongsTo('\\App\\Models\\Record', 'first_record_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function second_record(){
        return $this->belongsTo('\\App\\Models\\Record', 'second_record_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function round(){
        return $this->belongsTo('\\App\\Models\\Round', 'round_id');
    }


    /**
     * @return bool
     */
    public function canUserSeeResult(){
        if (Auth::user()->is_admin)
            return true;
        foreach ($this->teams as $team)
            if ($team->id == Auth::user()->id)
                return true;
        return false;
    }
}
