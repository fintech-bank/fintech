<?php

namespace App\Http\Controllers;

use App\Helper\AgencyHelper;
use App\Helper\CountryHelper;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        dd(CountryHelper::getCountriesAll());
    }
}
