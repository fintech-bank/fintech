@extends("reseller.layouts.layout")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Tableau de bord</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}"
                   class="text-muted text-hover-primary">{{ auth()->user()->name }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Tableau de bord</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <!--begin::Content-->
    <div class="d-flex flex-row-fluid">
        <!--begin::Container-->
        <div class="d-flex flex-column flex-row-fluid align-items-center">
            <!--begin::Menu-->
            <div class="d-flex flex-column flex-column-fluid mb-5 mb-lg-10">
                <!--begin::Brand-->
                <div class="d-flex flex-center pt-10 pt-lg-0 mb-10 mb-lg-0 h-lg-225px">
                    <!--begin::Sidebar toggle-->
                    <div class="btn btn-icon btn-active-color-primary w-30px h-30px d-lg-none me-4 ms-n15" id="kt_sidebar_toggle">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                        <span class="svg-icon svg-icon-1">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
											<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
										</svg>
									</span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Sidebar toggle-->
                    <!--begin::Logo-->
                    <a href="../../demo10/dist/index.html">
                        <img alt="Logo" src="/storage/logo/logo_carre.png" class="h-70px" />
                    </a>
                    <!--end::Logo-->
                </div>
                <!--end::Brand-->
                <!--begin::Row-->
                <div class="row g-7 w-xxl-1000px">
                    <div class="col">
                        <div class="card card-flush shadow-sm mb-10">
                            <div class="card-header">
                                <h3 class="card-title">Dernières demande de retrait</h3>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#AddWithdraw">
                                        Action
                                    </button>
                                </div>
                            </div>
                            <div class="card-body py-5">
                                <table class="table table-striped gy-5 gs-5">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Client</th>
                                            <th>Montant</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(auth()->user()->revendeur->dab->withdraws as $with)
                                            <tr>
                                                <td>{{ $with->reference }}</td>
                                                <td>{{ \App\Helper\CustomerHelper::getName($with->wallet->customer) }}</td>
                                                <td>{{ eur($with->amount) }}</td>
                                                <td>{!! \App\Helper\CustomerWithdrawHelper::getStatusWithdraw($with->status, true) !!}</td>
                                                <td>
                                                    <button class="btn btn-xs btn-circle btn-primary btnValidWithdraw" data-id="{{ $with->id }}">Valider le retrait</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card card-flush shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Dernière demande de dépots</h3>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-light">
                                        Action
                                    </button>
                                </div>
                            </div>
                            <div class="card-body py-5">

                            </div>
                            <div class="card-footer">
                                Footer
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Menu-->
            <!--begin::Footer-->
            <div class="d-flex flex-column-auto flex-center">

            </div>
            <!--end::Footer-->
        </div>
        <!--begin::Content-->
    </div>
    <!--begin::Content-->
    <div class="modal fade" data-bs-backdrop="static" tabindex="-1" id="ValidWithdraw">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Validation d'un retrait</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formValidWithdraw" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-base.underline
                            title="Information sur le retrait" class="w-450px mt-5 mb-5" />

                        <table class="table table-striped gy-7 gs-6">
                            <tbody>
                                <tr>
                                    <td>Identité</td>
                                    <td data-content="info_identity"></td>
                                </tr>
                                <tr>
                                    <td>Montant</td>
                                    <td data-content="info_amount"></td>
                                </tr>
                                <tr>
                                    <td>Etat de la demande</td>
                                    <td data-content="info_status"></td>
                                </tr>
                            </tbody>
                        </table>

                        <x-form.input
                            name="code"
                            type="password"
                            label="Code de retrait"
                            required="true" />
                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="AddWithdraw">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Nouvelle demande de retrait</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formAddWithdraw" action="{{ route('reseller.post-withdraw') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="customer_withdraw_dab_id" value="{{ auth()->user()->revendeur->dab->id }}">
                        <div class="mb-10">
                            <label for="customer_id" class="form-label">Client</label>
                            <select id="customer_id" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#AddWithdraw" name="customer_id" data-placeholder="Selectionner un client" data-allow-clear="true" onchange="selectCustomer(this)">
                                <option></option>
                                @foreach(\App\Models\Customer\Customer::where('status_open_account', 'terminated')->with('info')->get() as $user)
                                    @if($user->info->isVerified == true)
                                    <option value="{{ $user->id }}">{{ \App\Helper\CustomerHelper::getName($user) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="w-50 me-5">
                                <div class="mb-10">
                                    <label for="customer_wallet_id" class="form-label">Compte de retrait</label>
                                    <select id="customer_wallet_id" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#AddWithdraw" name="customer_wallet_id" data-placeholder="Selectionner un compte bancaire" data-allow-clear="true" onchange="getInfoWithdraw(this)">
                                        <option></option>

                                    </select>
                                </div>
                                <div class="mb-10">
                                    <label for="amount" class="required form-label">
                                        Montant Souhaité
                                        <i class="fas fa-info-circle text-primary fa-lg iconHelp ms-2"
                                           data-bs-toggle="popover"
                                           data-bs-custom-class="popover-dark" title="Aide"></i>
                                    </label>

                                    <input
                                        type="text"
                                        id="amount"
                                        name="amount"
                                        class="form-control form-control-solid" />

                                    <span class="text-muted help"></span>
                                </div>

                            </div>
                            <div class="card card-flush shadow-sm w-50 bg-gray-300">
                                <div class="card-body py-5" id="resultCustomer">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("reseller.script.dashboard")
@endsection
