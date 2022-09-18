<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Core\TypeVersion;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function typeAll()
    {
        $versions = TypeVersion::select('name')->get();
        $arr = [];

        foreach ($versions as $version) {
            $arr[] = $version->name;
        }
        return response()->json($arr);
    }
}
