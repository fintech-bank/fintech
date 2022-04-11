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
                <button class="btn btn-bank"><i class="fa-solid fa-plus me-2 fw-bold"></i> Nouvelle agence </button>
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
                        {{ \App\Helper\AgencyHelper::getCountryName($agency->country) }}
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
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("script")
    @include('admin.scripts.agence.index')
@endsection
