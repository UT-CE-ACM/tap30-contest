<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * @property integer id
 * @property string name
 * @property string version
 * @property string compile_command
 * @property string execute_command
 * @property string file_extension
 *
 *
 * Class Language
 * @package App\Models
 */
class Language extends BaseModel
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['*'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submits(){
        return $this->hasMany("\\App\\Models\\Submit", 'language_id');
    }

    public static function listLanguages(){
        $langs = Language::all();
        $result = [];
        foreach ($langs as $lang){
            $result[$lang->id] = $lang->name . ' - ' . $lang->version;
        }
        return $result;
    }
}
