<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $fillable = [
        'input', 'output',
    ];

    public function problem(){
        return $this->belongsTo('\\App\\Model\\Problem','problem_id');
    }
}
