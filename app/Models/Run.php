<?php

namespace App\Models;

use DateTime;

/**
 * @property integer id
 * @property double RMSE
 * @property string status
 * @property string message
 * @property integer round_id
 * @property Round round
 * @property integer submit_id
 * @property integer test_case_id
 * @property Submit submit
 * @property TestCase test_case
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * Class Run
 * @package App\Models
 */
class Run extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'RMSE', 'status', 'message', 'round_id', 'submit_id', 'test_case_id'
    ];

    public static $status = [
        "AC" => "general.accepted"
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submit(){
        return $this->belongsTo('\\App\\Models\\Submit', 'submit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function test_case(){
        return $this->belongsTo('\\App\\Models\\TestCase', 'test_case_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function round(){
        return $this->belongsTo('\\App\\Models\\Round', 'round_id');
    }
}
