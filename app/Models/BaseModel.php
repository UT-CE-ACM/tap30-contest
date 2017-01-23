<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 12/31/16
 * Time: 12:37 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Model
{
    /*
     * file actions
     */

    /**
     * @param string $input_name
     */
    public function saveFile($input_name)
    {
        //save file from input to uploads folder
        $filename = request()->file($input_name)->getClientOriginalName();
        $destinationPath = 'uploads/' . (string)microtime(true) . str_random(10);

        request()->file($input_name)->move($destinationPath, $filename);

        $file = new Attachment();
        $file->path = $destinationPath;
        $file->real_name = $filename;
        if ($this->id == Null)
            $this->save();
        $this->attachment()->save($file);
    }
}
