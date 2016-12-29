<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    public function team(){
        return $this->belongsTo("\\App\\Models\\User", "user_id");
    }
}
