<?php

namespace App\Models;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string attachment_type
 * @property integer attachment_id
 * @property string path
 * @property string real_name
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * Class Attachment
 * @package App\Models
 */
class Attachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path', 'real_name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachable(){
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getPath(){
        return '/'. $this->path . '/' . $this->real_name;
    }
}
