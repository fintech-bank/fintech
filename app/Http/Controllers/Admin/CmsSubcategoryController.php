<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cms\CmsCategory;
use Illuminate\Http\Request;

class CmsSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $category_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($category_id)
    {
        $subs = CmsCategory::with('subcategories')->find($category_id)->subcategories;

        return response()->json($subs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $category_id
     * @return void
     */
    public function store(Request $request, $category_id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $category_id
     * @param int $id
     * @return void
     */
    public function destroy($category_id, $id)
    {
        //
    }
}
