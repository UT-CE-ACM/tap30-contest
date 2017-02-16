<?php

namespace App\Models;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer language_id
 * @property Language language
 * @property integer user_id
 * @property integer problem_id
 * @property User team
 * @property Problem problem
 * @property Attachment attachment
 * @property Run[] runs
 * @property integer judge_request
 * @property DateTime created_at
 * @property DateTime updated_at
 * @property DateTime deleted_at
 *
 * Class Submit
 * @package App\Models
 */
class Submit extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    public static $langs = array(
        "C - gcc 5.4.0",
        "C++ - g++ 9.0",
        "Java - java 1.6",
        "Python - python 2.7",
        "Python - python 3.5",
        "Matlab"
    );

    public function language(){
        return $this->belongsTo("\\App\\Models\\Language", "language_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function problem(){
        return $this->belongsTo("\\App\\Models\\Problem", "problem_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(){
        return $this->belongsTo("\\App\\Models\\User","user_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function attachment(){
        return $this->morphOne("\\App\\Models\\Attachment", 'attachable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function runs(){
        return $this->hasMany('\\App\\Models\\Run', 'submit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function log(){
        return $this->hasOne('\\App\\Models\\Log', 'submit_id');
    }
}
