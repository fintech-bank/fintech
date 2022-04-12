@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Agence</h1>
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
            <li class="breadcrumb-item text-dark">Gestion des agences</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="card shadow-lg">
        <div class="card-header">
            <h3 class="card-title">Liste des agences</h3>
            <div class="card-toolbar">
                <button class="btn btn-bank" data-bs-toggle="modal" data-bs-target="#add_agency"><i class="fa-solid fa-plus me-2 fw-bold"></i> Nouvelle agence </button>
            </div>
        </div>
        <div class="card-body">
            <table id="liste_agence" class="table table-row-bordered gy-5">
                <thead>
                <tr class="fw-bold fs-6 text-muted">
                    <th>Nom de l'agence</th>
                    <th>Information</th>
                    <th>Adresse</th>
                    <th>En ligne</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach(\App\Models\Core\Agency::all() as $agency)
                <tr>
                    <td>{{ $agency->name }}</td>
                    <td>
                        <strong>BIC:</strong> {{ $agency->bic }}<br>
                        <strong>Code Banque:</strong> {{ $agency->code_banque }}<br>
                        <strong>Code Agence:</strong> {{ $agency->code_agence }}<br>
                    </td>
                    <td>
                        {{ $agency->address }}<br>
                        {{ $agency->postal }} {{ $agency->city }}<br>
                        {{ $agency->country }}
                    </td>
                    <td>{!! \App\Helper\AgencyHelper::getOnline($agency->online) !!}</td>
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
                                <a href="#" class="menu-link px-3 edit" data-agency="{{ $agency->id }}">
                                    Editer
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3 py-3">
                                <a href="#" class="menu-link px-3 text-danger delete" data-agency="{{ $agency->id }}">
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
    <div class="modal fade" tabindex="-1" id="add_agency">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Nouvelle Agence</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formAddAgency" action="{{ route('agences.store') }}" method="post" novalidate>
                    <div class="modal-body">
                        <x-form.input
                            name="name"
                            type="text"
                            label="Nom de l'agence"
                            required="true" />

                        <div class="row">
                            <div class="col-md-4">
                                <x-form.input
                                    name="code_banque"
                                    type="text"
                                    label="Code banque"
                                    value="{{ config('config.code_banque') }}"
                                    required="true" />
                            </div>
                            <div class="col-md-4">
                                <x-form.input
                                    name="code_agence"
                                    type="text"
                                    label="Code Agence"
                                    value="{{ rand(10000,99999) }}"
                                    required="true"
                                    help="true"
                                    helpText="Générer automatiquement"/>
                            </div>
                            <div class="col-md-4">
                                <x-form.input
                                    name="bic"
                                    type="text"
                                    label="BIC"
                                    value="FINFRPPXXX"
                                    required="true"
                                    help="true"
                                    helpText="Générer automatiquement" />
                            </div>
                        </div>

                        <span class="d-inline-block position-relative ms-2 mb-5">
                            <span class="d-inline-block mb-2 fs-2 fw-bolder">
                                Adresse de l'agence
                            </span>
                            <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-bank translate rounded"></span>
                        </span>
                        <x-form.input
                            name="address"
                            type="text"
                            label="Adresse Postal"
                            required="true" />

                        <div class="row">
                            <div class="col-md-4">
                                <x-form.input
                                    name="postal"
                                    type="text"
                                    label="Code Postal"
                                    required="true" />
                            </div>
                            <div class="col-md-8">
                                <x-form.input
                                    name="city"
                                    type="text"
                                    label="Ville"
                                    required="true" />
                            </div>
                        </div>
                        <x-form.select-modal
                            name="country"
                            parent="#add_agency"
                            :datas="\App\Helper\CountryHelper::getCountriesAll()"
                            label="Pays"
                            placeholder="Veuillez selectionner un pays"
                            required="true" />

                        <x-form.switches
                            name="online"
                            value="1"
                            label="Banque en ligne" />

                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="edit_agency">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Edition d'une agence</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formEditAgency" action="" method="post" novalidate>
                    <div class="modal-body">
                        <x-form.input
                            name="name"
                            type="text"
                            label="Nom de l'agence"
                            required="true" />

                        <div class="row">
                            <div class="col-md-4">
                                <x-form.input
                                    name="code_banque"
                                    type="text"
                                    label="Code banque"
                                    value="{{ config('config.code_banque') }}"
                                    required="true" />
                            </div>
                            <div class="col-md-4">
                                <x-form.input
                                    name="code_agence"
                                    type="text"
                                    label="Code Agence"
                                    value="{{ rand(10000,99999) }}"
                                    required="true"
                                    help="true"
                                    helpText="Générer automatiquement"/>
                            </div>
                            <div class="col-md-4">
                                <x-form.input
                                    name="bic"
                                    type="text"
                                    label="BIC"
                                    value="FINFRPPXXX"
                                    required="true"
                                    help="true"
                                    helpText="Générer automatiquement" />
                            </div>
                        </div>

                        <span class="d-inline-block position-relative ms-2 mb-5">
                            <span class="d-inline-block mb-2 fs-2 fw-bolder">
                                Adresse de l'agence
                            </span>
                            <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-bank translate rounded"></span>
                        </span>
                        <x-form.input
                            name="address"
                            type="text"
                            label="Adresse Postal"
                            required="true" />

                        <div class="row">
                            <div class="col-md-4">
                                <x-form.input
                                    name="postal"
                                    type="text"
                                    label="Code Postal"
                                    required="true" />
                            </div>
                            <div class="col-md-8">
                                <x-form.input
                                    name="city"
                                    type="text"
                                    label="Ville"
                                    required="true" />
                            </div>
                        </div>
                        <x-form.select-modal
                            name="country"
                            parent="#add_agency"
                            :datas="\App\Helper\CountryHelper::getCountriesAll()"
                            label="Pays"
                            placeholder="Veuillez selectionner un pays"
                            required="true" />

                        <x-form.switches
                            name="online"
                            value="1"
                            label="Banque en ligne" />

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
    @include('admin.scripts.agence.index')
@endsection
