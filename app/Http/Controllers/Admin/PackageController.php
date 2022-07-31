<?php

namespace App\Http\Controllers\Admin;

use App\Helper\LogHelper;
use App\Helper\PackageHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.packages.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required',
            'type_prlv' => 'required',
        ]);

        $request->merge([
            'type_prlv' => PackageHelper::setTypePrlv($request->get('type_prlv')),
        ]);

        try {
            $package = Package::create($request->all());

            LogHelper::notify('notice', "Création d'un package: ".$request->get('name'));

            return response()->json($package);
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());

            return response()->json($exception->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $package = Package::find($id);

            return response()->json($package);
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());

            return response()->json($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Package::find($id)->delete();

            LogHelper::notify('notice', "Suppression d'un package");

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());

            return response()->json($exception->getMessage());
        }
    }
}
