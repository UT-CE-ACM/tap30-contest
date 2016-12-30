<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
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
