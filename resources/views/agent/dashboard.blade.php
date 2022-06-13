@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Tableau de Bord</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}" class="text-muted text-hover-primary">Agence: {{ auth()->user()->agency->name }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Tableau de Bord</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="row g-5 g-xl-8">
        <div class="col-xl-6">
            <a href="{{ route('agent.customer.index') }}" class="card bg-{{ random_color() }} hoverable card-xl-stretch mb-5 mb-xl-8 cardAllUser">
                <!--begin::Body-->
                <div class="card-body">
                    <i class="fa-solid fa-users text-white fa-3x ms-n1"></i>
                    <div class="text-white fw-bolder fs-2 mb-2 mt-5 count">0</div>
                    <div class="fw-bold text-white">Nombre total de clients</div>
                </div>
                <!--end::Body-->
            </a>
        </div>
        <div class="col-xl-6">
            <a href="{{ route('agent.customer.index') }}" class="card bg-{{ random_color() }} hoverable card-xl-stretch mb-5 mb-xl-8 cardVerifiedUser">
                <!--begin::Body-->
                <div class="card-body">
                    <i class="fa-solid fa-users text-white fa-3x ms-n1"></i>
                    <div class="text-white fw-bolder fs-2 mb-2 mt-5 count">0</div>
                    <div class="fw-bold text-white">Nombre total de clients vérifier</div>
                </div>
                <!--end::Body-->
            </a>
        </div>
    </div>
    <div class="row g-5 g-xl-8">
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Rapport mensuel sur les dépôts et les retraits</h3>
                </div>
                <div class="card-body">
                    <div id="chartReport" style="height: 350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-success hoverable card-xl-stretch mb-7 mb-xl-10 cardDeposit">
                        <div class="card-body d-flex flex-column flex-center text-white">
                            <div class="amountAll fw-bolder fs-1">0,00 €</div>
                            <div class="fs-6 pb-5">Total de dépot en banque</div>
                            <div class="amountWait fw-bolder fs-1">0,00 €</div>
                            <div class="fs-6">Dépot en attente</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-danger hoverable card-xl-stretch mb-7 mb-xl-10 cardWithdraw">
                        <div class="card-body d-flex flex-column flex-center text-white">
                            <div class="amountAll fw-bolder fs-1" >0,00 €</div>
                            <div class="fs-6 pb-5">Total de retrait en banque</div>
                            <div class="amountWait fw-bolder fs-1">0,00 €</div>
                            <div class="fs-6">Retrait en attente</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card bg-info hoverable card-xl-stretch mb-7 mb-xl-10 cardAgency">
                        <div class="card-body d-flex flex-column flex-center text-white">
                            <div class="amountAll fw-bolder fs-1" >0,00 €</div>
                            <div class="fs-6 pb-5">Montant disponible en agence</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card bg-info hoverable card-xl-stretch mb-7 mb-xl-10 cardLoan">
                        <div class="card-body d-flex flex-column flex-center text-white">
                            <div class="amountAll fw-bolder fs-1" >0,00 €</div>
                            <div class="fs-6 pb-5">Montant disponible pour les pret</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script type="text/javascript" nomodule src="/assets/plugins/custom/countup/dist/countUp.umd.js"></script>
    @include("agent.scripts.dashboard")
@endsection
