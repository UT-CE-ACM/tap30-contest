<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submit extends Model
{
    protected $fillable = [
        'status',
    ];

    public function problem(){
        return $this->belongsTo("\\App\\Models\\Problem","problem_id");
    }

    public function owner(){
        return $this->belongsTo("\\App\\Models\\User","user_id");
    }

    public function attachment(){
        return $this->morphOne("\\App\\Models\\Attachment", 'attachable');
    }

}
