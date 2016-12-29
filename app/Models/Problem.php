<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $fillable = [
        'title', 'description',
    ];

    public function samples(){
        return $this->hasMany("\\App\\Models\\Sample",'sample_id');
    }
    public function submits(){
        return $this->hasMany("\\App\\Models\\Submit","problem_id");
    }
}
