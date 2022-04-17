<?php

namespace App\Http\Controllers\Admin;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\EpargnePlan;
use Illuminate\Http\Request;

class EpargneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.epargnes.index');
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
            "profit_percent" => "required",
            "lock_days" => "required",
            "limit" => "required"
        ]);

        try {
            $plan = EpargnePlan::create($request->all());

            LogHelper::notify('notice', "Création d'un plan d'épargne: ".$request->get('name'));
            return response()->json($plan);
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
            $plan = EpargnePlan::find($id);
            return response()->json($plan);
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
            $plan = EpargnePlan::find($id)->update($request->all());
            LogHelper::notify('notice', "Edition d'un plan d'épargne: ".$request->get('name'));
            return response()->json($plan);
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
            EpargnePlan::find($id)->delete();
            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
}
