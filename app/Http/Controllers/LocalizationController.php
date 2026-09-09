<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($locale)
    {
        if (! in_array($locale, config('localization.locales'))) {
            App::setLocale('en');
        }

        session(['lang' => $locale]);

        return redirect()->back();
    }
}
