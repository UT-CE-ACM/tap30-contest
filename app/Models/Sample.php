<?php

namespace App\Models;

class Sample extends BaseModel
{
    protected $fillable = [
        'input', 'output', 'problem_id',
    ];

    public function problem(){
        return $this->belongsTo('\\App\\Models\\Problem', 'problem_id');
    }

    public function attachment(){
        return $this->morphOne("\\App\\Models\\Attachment", 'attachable');
    }
}
