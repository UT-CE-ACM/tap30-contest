<?php

namespace App\Models;


/**
 * @property integer id
 * @property string status
 * @property string message
 * @property integer submit_id
 * @property Submit submit
 *
 * Class Log
 * @package App\Models
 */
class Log extends BaseModel
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'message', 'submit_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submit(){
        return $this->belongsTo('\\App\\Models\\Submit', 'submit_id');
    }
}
