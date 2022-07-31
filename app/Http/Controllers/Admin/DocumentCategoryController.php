<?php

namespace App\Http\Controllers\Admin;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\DocumentCategory;
use Illuminate\Http\Request;

class DocumentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.document.index');
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
        ]);

        try {
            $category = DocumentCategory::create($request->all());
            LogHelper::notify('notice', "Création d'une catégorie de document: ".$request->get('name'));

            return response()->json($category);
        } catch (\Exception $exception) {
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
            $category = DocumentCategory::find($id);

            return response()->json($category);
        } catch (\Exception $exception) {
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
            $category = DocumentCategory::find($id)->update($request->all());
            LogHelper::notify('notice', "Création d'une catégorie de document: ".$request->get('name'));

            return response()->json($category);
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
            DocumentCategory::find($id)->delete();
            LogHelper::notify('notice', "Suppression d'une catégorie de document");

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());

            return response()->json($exception->getMessage());
        }
    }
}
