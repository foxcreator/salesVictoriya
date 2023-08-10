<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function changeLanguage($locale)
    {
        session(['locale' => $locale]);
        if (in_array($locale, ['en', 'ru', 'uk'])) {
            App::setLocale($locale);
            return redirect()->back();
        }
        return redirect()->back();
    }


}
