<?php

namespace App\Models;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string title
 * @property string description
 * @property Attachment attachment
 * @property Submit[] submits
 * @property Sample[] samples
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * Class Problem
 * @package App\Models
 */
class Problem extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function samples(){
        return $this->hasMany("\\App\\Models\\Sample", 'problem_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submits(){
        return $this->hasMany("\\App\\Models\\Submit", "problem_id");
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function attachment(){
        return $this->morphOne("\\App\\Models\\Attachment", 'attachable');
    }
}
