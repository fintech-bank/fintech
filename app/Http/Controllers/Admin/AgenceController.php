<?php

namespace App\Http\Controllers\Admin;

use App\Helper\AgencyHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Agency;
use Illuminate\Http\Request;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.agence.index');
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
            'bic' => 'required',
            'code_banque' => 'required|numeric',
            'code_agence' => 'required|numeric',
            'address' => 'required|string',
            'postal' => 'required|numeric',
            'city' => 'required|string',
            'country' => 'required|string',
        ]);

        try {
            $agence = Agency::create($request->all());
            ob_start(); ?>
            <tr>
                <td><?= $agence->name; ?></td>
                <td>
                    <strong>BIC:</strong> <?= $agence->bic; ?><br>
                    <strong>Code Banque:</strong> <?= $agence->code_banque; ?><br>
                    <strong>Code Agence:</strong> <?= $agence->code_agence; ?><br>
                </td>
                <td>
                    <?= $agence->address; ?><br>
                    <?= $agence->postal; ?> <?= $agence->city; ?><br>
                    <?= $agence->country ?>
                </td>
                <td><?= AgencyHelper::getOnline($agence->online) ?></td>
                <td>
                    <button class="btn btn-icon btn-circle btn-outline btn-outline-dashed btn-outline-primary rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="-30px, 20px">
                        <i class="fa-solid fa-ellipsis rotate-90"></i>
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Actions</div>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu separator-->
                        <div class="separator mb-3 opacity-75"></div>
                        <!--end::Menu separator-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">
                                Editer
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3 py-3">
                            <a href="#" class="menu-link px-3 text-danger">
                                Supprimer
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </td>
            </tr>
            <?php
            $content = ob_get_clean();

            return response()->json([
                'agence' => $agence,
                'html' => $content,
            ]);
        } catch (\Exception $exception) {
            \Log::critical($exception->getMessage());

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
            $agence = Agency::find($id);

            return response()->json($agence);
        } catch (\Exception $exception) {
            \Log::critical($exception->getMessage());

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
            Agency::find($id)->update($request->all());

            return response()->json([
                'agence' => Agency::find($id),
            ]);
        } catch (\Exception $exception) {
            \Log::critical($exception->getMessage());

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
            Agency::find($id)->delete();

            return response()->json();
        } catch (\Exception $exception) {
            \Log::critical($exception->getMessage());

            return response()->json($exception->getMessage());
        }
    }
}
