<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 12/30/16
 * Time: 2:35 PM
 */

namespace App\Http\Controllers;


class BaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
}