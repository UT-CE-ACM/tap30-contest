<?php

namespace App\Models;

use Faker\Provider\DateTime;

/**
 * @property integer id
 * @property string input
 * @property string output
 * @property integer problem_id
 * @property Problem problem
 * @property Attachment attachment
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * Class Sample
 * @package App\Models
 */
class Sample extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'input', 'output', 'problem_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function problem(){
        return $this->belongsTo('\\App\\Models\\Problem', 'problem_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function attachment(){
        return $this->morphOne("\\App\\Models\\Attachment", 'attachable');
    }
}
