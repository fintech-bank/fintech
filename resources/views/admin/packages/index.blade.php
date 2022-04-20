@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Packages</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Administration</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Gestion des Packages</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
						<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
					</svg>
				</span>
                <!--end::Svg Icon-->
                <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Rechercher une banque">
            </div>
        </div>
        <div class="card-toolbar">
            <button class="btn btn-bank" data-bs-toggle="modal" data-bs-target="#add_packages"><i class="fa-solid fa-plus"></i> Nouveau packages</button>
        </div>
    </div>
    <div class="card-body">
        <table id="liste_packages" class="table table-row-bordered gy-5">
            <thead>
            <tr class="fw-bold fs-6 text-muted">
                <th>Nom du plan</th>
                <th>Prix</th>
                <th>Fréquence de Prlv</th>
                <th>Information de carte</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Models\Core\Package::all() as $package)
                <tr>
                    <td>
                        {{ $package->name }}
                    </td>
                    <td>{{ eur($package->price) }}</td>
                    <td>{{ $package->type_prlv }}</td>
                    <td>
                        <strong>Nombre de carte Physique:</strong> {{ $package->nb_carte_physique }}<br>
                        <strong>Nombre de carte Virtuel:</strong> {{ $package->nb_carte_virtuel }}<br>
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

                            <div class="menu-item px-3 py-3">
                                <a href="#" class="menu-link px-3 text-dark info" data-package="{{ $package->id }}">
                                    Information
                                </a>
                            </div>

                            <!--begin::Menu item-->
                            <div class="menu-item px-3 py-3">
                                <a href="#" class="menu-link px-3 text-danger delete" data-package="{{ $package->id }}">
                                    Supprimer
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="show_packages">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-bank">
                <h5 class="modal-title text-white" id="package_name"></h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark text-white"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="d-flex flex-row justify-content-between">
                    <div class="mb-5">
                        <table class="table fs-3">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Tarif</td>
                                    <td id="package_price">{{ eur(5.50) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Fréquence de prélèvement</td>
                                    <td id="package_prlv">{{ eur(5.50) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="separator my-5"></div>
                        <div id="options"></div>
                    </div>
                    <div class="d-flex flex-row flex-stack mb-5 border border-3 w-300px p-10">
                        <div class="symbol symbol-50px me-5" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Carte Physique">
                            <div class="symbol-label fs-2 fw-bold"><i class="fa fa-credit-card"></i></div>
                            <span class="symbol-badge badge badge-circle bg-success top-100 start-100" id="package_cb_physique">5</span>
                        </div>
                        <div class="symbol symbol-50px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Carte Virtuel">
                            <div class="symbol-label fs-2 fw-bold"><i class="fa fa-credit-card-alt"></i></div>
                            <span class="symbol-badge badge badge-circle bg-success top-100 start-100" id="package_cb_virtuel">5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="add_packages">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-bank">
                <h5 class="modal-title text-white">Nouveau Package</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark text-white"></i>
                </div>
                <!--end::Close-->
            </div>

            <form id="formAddPlan" action="{{ route('packages.store') }}" method="post" novalidate>
                <div class="modal-body">
                    <x-form.input
                        name="name"
                        type="text"
                        label="Nom du plan"
                        required="true" />

                    <x-form.input
                        name="price"
                        type="text"
                        label="Prix du plan"
                        required="true" />

                    <x-form.select
                        name="type_prlv"
                        :datas="\App\Helper\PackageHelper::getTypePrlvToArray()"
                        label="Fréquence de prélèvement" />

                    <div class="separator my-10"></div>
                    <h3 class="mb-5">Options</h3>
                    <div class="d-flex flex-column justify-content-evenly">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="visa_classic" value="1" checked id="flexSwitchDefault"/>
                            <label class="form-check-label" for="flexSwitchDefault">
                                Carte Visa
                            </label>
                        </div>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="check_deposit" value="1" checked id="flexSwitchDefault"/>
                            <label class="form-check-label" for="flexSwitchDefault">
                                Dépot de cheque
                            </label>
                        </div>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="payment_withdraw" value="1" checked id="flexSwitchDefault"/>
                            <label class="form-check-label" for="flexSwitchDefault">
                                Retraits & Paiements illimité
                            </label>
                        </div>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="overdraft" value="1" id="flexSwitchDefault"/>
                            <label class="form-check-label" for="flexSwitchDefault">
                                Découvert Autorisé
                            </label>
                        </div>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="cash_deposit" value="1" id="flexSwitchDefault"/>
                            <label class="form-check-label" for="flexSwitchDefault">
                                Dépot d'espèce
                            </label>
                        </div>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="withdraw_international" value="1" id="flexSwitchDefault"/>
                            <label class="form-check-label" for="flexSwitchDefault">
                                Retrait d'espèce hors zone euro
                            </label>
                        </div>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="payment_international" value="1" id="flexSwitchDefault"/>
                            <label class="form-check-label" for="flexSwitchDefault">
                                Payment hors zone euro
                            </label>
                        </div>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="check" value="1" id="flexSwitchDefault"/>
                            <label class="form-check-label" for="flexSwitchDefault">
                                Chéquier
                            </label>
                        </div>
                    </div>
                    <div class="separator my-10"></div>
                    <h3 class="mb-10">Carte Bancaire</h3>
                    <div class="d-flex flex-row justify-content-evenly">
                        <x-form.input
                            name="nb_carte_physique"
                            type="text"
                            label="Nombre de carte Physique"
                            value="1" />
                        <x-form.input
                            name="nb_carte_virtuel"
                            type="text"
                            label="Nombre de carte virtuel"
                            value="1" />
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
    @include("admin.scripts.packages.index")
@endsection
