<?php

namespace App\Http\Controllers\Admin;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Bank;
use Illuminate\Http\Request;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.bank.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|string",
            'logo' => "required|url",
            'primary_color' => "required",
            'country' => 'required',
            'bic' => 'required',
        ]);

        try {
            $bank = Bank::create($request->all());
            ob_start();
            ?>
            <tr>
                <td>
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50px symbol-2by3 me-5">
                            <img src="<?= $bank->logo ?>" class="" alt="">
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Text-->
                        <div class="flex-grow-1">
                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?= $bank->name ?></a>
                            <span class="text-muted d-block fw-bold"><?= $bank->bic ?></span>
                        </div>
                        <!--end::Text-->
                    </div>
                </td>
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
                            <a href="#" class="menu-link px-3 edit" data-bank="<?= $bank->id ?>">
                                Editer
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3 py-3">
                            <a href="#" class="menu-link px-3 text-danger delete" data-bank="<?= $bank->id ?>">
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

            LogHelper::notify('notice', "Création de la banque: ".$bank->name);

            return response()->json([
                "bank" => $bank,
                "html" => $content
            ]);
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
            $bank = Bank::find($id);

            return response()->json($bank);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
