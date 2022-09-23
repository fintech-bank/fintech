<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Core\TypeVersion;
use App\Models\Core\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function get(string $version_name)
    {
        $version = Version::where('name', $version_name)->first();

        return response()->json($version);
    }

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
