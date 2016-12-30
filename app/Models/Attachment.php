<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'path', 'real_name'
    ];

    public function attachable(){
        return $this->morphTo();
    }

    public function getPath(){
        return $this->path . '/' . $this->real_path;
    }
}
