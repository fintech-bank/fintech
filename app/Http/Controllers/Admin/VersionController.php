<?php

namespace App\Http\Controllers\Admin;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VersionRequest;
use App\Models\Core\TypeVersion;
use App\Models\Core\Version;
use App\Models\Core\VersionType;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function index()
    {
        $versions = Version::with('types')->get();

        return view('admin.version.index', compact('versions'));
    }

    public function create()
    {
        return view('admin.version.create');
    }

    public function store(VersionRequest $request)
    {
        try {
            $version = Version::create($request->except('types'));

            foreach (json_decode($request->types, true) as $type) {
                $terme = $type['value'];
                $search = TypeVersion::where('name', 'LIKE', '%'.$terme.'%')->first();
                $version->types()->attach($search);
            }
            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json([
                'errors' => [
                    'Erreur Serveur' => $exception->getMessage()
                ]
            ], 500);
        }
    }
}
