<?php

namespace App\Http\Controllers;

use App\Helper\AgencyHelper;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        dd(AgencyHelper::getCountryName('fr'));
    }
}
