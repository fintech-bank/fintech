<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GithubController extends Controller
{
    public function webhook(Request $request) {
        return $request->all();
    }
}
