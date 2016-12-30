<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 12/31/16
 * Time: 1:14 AM
 */

namespace App\Http\Controllers;


use App\Models\Attachment;

class AttachmentController extends BaseController
{
    public function remove($id){
        $file = Attachment::find($id);
        if($file != null)
            $file->delete();
        return back();
    }
}