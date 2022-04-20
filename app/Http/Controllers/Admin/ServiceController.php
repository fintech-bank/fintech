<?php

namespace App\Http\Controllers\Admin;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.services.index');
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
            'name' => "required|string",
            'price' => "required",
            'type_prlv' => "required"
        ]);

        try {
            $service = Service::create([
                "name" => $request->get('name'),
                "price" => $request->get('price'),
                "type_prlv" => $request->get('type_prlv'),
                "package_id" => $request->get('package_id'),
            ]);

            LogHelper::notify('notice', "Création d'un service: " . $request->get('name'));
            return response()->json($service);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $service = Service::find($id);

            return response()->json($service);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $service = Service::find($id);
            $service->name = $request->get('name');
            $service->price = $request->get('price');
            $service->type_prlv = $request->get('type_prlv');
            $service->package_id = $request->get('package_id');
            $service->save();

            LogHelper::notify('notice', "Edition d'un service: " . $request->get('name'));
            return response()->json($service);
        }catch (\Exception $exception) {
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
            Service::find($id)->delete();

            LogHelper::notify('notice', "Suppression d'un service");
            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
}
