<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function getLang() {
        return app()->getLocale();
    }

    public function setLang($lang){
        session()->put('lang', $lang);
        return redirect()->back();
    }
}
