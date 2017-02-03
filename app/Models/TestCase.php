<?php

namespace App\Models;

use DateTime;

/**
 * @property integer id
 * @property integer round_id
 * @property Round round
 * @property Attachment[] attachments
 * @property Run[] runs
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * Class TestCase
 * @package App\Models
 */
class TestCase extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'round_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments(){
        return $this->morphMany("\\App\\Models\\Attachment", 'attachable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function runs(){
        return $this->hasMany('\\App\\Models\\Run', 'test_case_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function round(){
        return $this->belongsTo('\\App\\Models\\Round', 'round_id');
    }
}
