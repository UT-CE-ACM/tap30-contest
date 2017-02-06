<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 12/31/16
 * Time: 12:37 AM
 */

namespace App\Models;

use App\Utils\Jalali\jDate;
use App\Utils\Validation\DataValidation;
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
    public function saveFile($input_name, $hasManyAttachments = false)
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
        if ($hasManyAttachments)
            $this->attachments()->save($file);
        else
            $this->attachment()->save($file);
    }

    /**
     * @return array
     */
    /*public function toArray()
    {
        $parentResponse = parent::toArray();
        foreach ($parentResponse as $key => $value) {
            if (DataValidation::validateDate($value)) {
                $parentResponse[$key . "_jalali"] = jDate::forge($value)->format("Y/m/d H:i");
            }
        }
        $parentResponse['className'] = get_class($this);
        return $parentResponse;
    }*/
}
