<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cms\CmsCategory;
use App\Models\Cms\CmsSubCategory;
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

        ob_start();
        foreach ($subs as $sub) {
            ?>
        <tr>
            <td><?= $sub->name ?></td>
            <td>
                <form action="<?= route('subcategory.destroy', [$category_id, $sub->id]) ?>">
                    <button type="submit" class="btn btn-icon btn-danger"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
        <?php
        }

        return response()->json(ob_get_clean());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($category_id, $id)
    {
        CmsSubCategory::find($id)->delete();

        return redirect()->back();
    }
}
