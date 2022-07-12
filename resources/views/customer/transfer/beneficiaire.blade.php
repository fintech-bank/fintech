@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Mes Bénéficiaires</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}"
                   class="text-muted text-hover-primary">{{ \App\Helper\CustomerHelper::getName($customer) }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Mes Bénéficiaires</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="d-flex flex-row justify-content-between align-items-center bg-white p-10 mb-10 rounded-2">
        <div class="d-flex flex-column">
            <a href="{{ url()->previous(true) }}" class="d-flex flex-row align-items-center text-dark mb-5">
                <i class="fa-solid fa-arrow-left me-2"></i>
                Retour
            </a>
            <div class="fs-1 fw-bold">Mes Bénéficiaires</div>
        </div>
        <button class="btn btn-outline btn-outline-bank btn-active-light-primary btn-lg" data-bs-toggle="modal" data-bs-target="#AddBeneficiaire"><i class="fa-solid fa-plus me-3"></i> Nouveau bénéficiaire</button>
    </div>
    <div class="card shadow-sm">
        <div id="search_beneficiaire" data-kt-search-keypress="true"
             data-kt-search-min-length="2"
             data-kt-search-enter="true"
             data-kt-search-layout="inline">
            <div class="card-header">
                <div class="card-title">
                    <x-form.input-group
                        name="search"
                        symbol="<i class='fa-solid fa-search'></i>"
                        placement="left"
                        placeholder="Rechercher un bénéficiaire"
                        class="m-5 w-350px" />
                </div>
            </div>
            <div class="card-body" id="listeBeneficiaire">
                @foreach($customer->beneficiaires()->get() as $beneficiaire)
                    <a href="" class="card shadow-sm mb-5 text-black-50 text-hover-primary">
                        <div class="card-body d-flex flex-row justify-content-between align-items-center" data-action="show" data-beneficiaire="{{ $beneficiaire->id }}">
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-row align-items-center fs-6">
                                    <i class="fa-solid fa-square text-{{ random_color() }} me-2"></i> {{ $beneficiaire->bankname }}
                                </div>
                                <div class="fs-3 fw-bolder">{{ \App\Helper\CustomerTransferHelper::getNameBeneficiaire($beneficiaire) }}</div>
                            </div>
                            {{ $beneficiaire->iban }}
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="AddBeneficiaire">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouveau Bénéficiaire</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmarks fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formAddBeneficiaire" action="{{ route('customer.beneficiaire.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex flex-row mb-10">
                            <x-form.radio
                                name="type"
                                value="corporate"
                                for="typePro"
                                label="Professionnel" function="onchange" nameFunction="showCorporate()" checked="checked" />

                            <x-form.radio
                                name="type"
                                value="retail"
                                for="typePart"
                                label="Particulier" function="onchange" nameFunction="showCorporate()" />
                        </div>

                        <div id="corporate" class="d-none">
                            <h3 class="fw-bolder mb-2">Compte Professionnel</h3>
                            <x-form.input
                                name="company"
                                type="text"
                                label="Bénéficiaire" />
                        </div>
                        <div id="retail" class="d-none">
                            <h3 class="fw-bolder mb-2">Compte Personnel</h3>
                            <div class="d-flex flex-row mb-5">
                                <x-form.radio
                                    name="civility"
                                    value="M"
                                    for="typeMonsieur"
                                    label="Monsieur" />

                                <x-form.radio
                                    name="civility"
                                    value="MME"
                                    for="typeMadame"
                                    label="Madame" />

                                <x-form.radio
                                    name="civility"
                                    value="MLLE"
                                    for="typeMademoiselle"
                                    label="Mademoiselle" />
                            </div>
                            <div class="d-flex flex-row">
                                <x-form.input
                                    name="firstname"
                                    type="text"
                                    label="Nom" />

                                <x-form.input
                                    name="lastname"
                                    type="text"
                                    label="Prénom" />
                            </div>
                        </div>
                        <div class="separator border-2 my-2"></div>
                        <div class="mb-10">
                            <label for="bank_id" class="form-label">Banque du client</label>
                            <select id="bank_id" class="form-select" name="bank_id" data-control="select2" data-dropdown-parent="#AddBeneficiaire" data-placebolder="Selectionner une banque" data-allow-clear="true">
                                <option value=""></option>
                                @foreach(\App\Models\Core\Bank::all() as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form.input
                            name="iban"
                            type="text"
                            label="IBAN" />

                        <x-form.input
                            name="bic"
                            type="text"
                            label="BIC" />

                        <x-form.checkbox
                            name="titulaire"
                            value="1"
                            label="Etes-vous titulaire de ce compte ?" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="EditBeneficiaire">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edition d'un bénéficiaire</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmarks fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formEditBeneficiaire" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div id="corporate">
                            <x-form.input
                                name="company"
                                type="text"
                                label="Bénéficiaire" />
                        </div>
                        <div id="retail">
                            <div class="d-flex flex-row mb-5">
                                <x-form.radio
                                    name="civility"
                                    value="M"
                                    for="typeMonsieur"
                                    label="Monsieur" />

                                <x-form.radio
                                    name="civility"
                                    value="MME"
                                    for="typeMadame"
                                    label="Madame" />

                                <x-form.radio
                                    name="civility"
                                    value="MLLE"
                                    for="typeMademoiselle"
                                    label="Mademoiselle" />
                            </div>
                            <div class="d-flex flex-row">
                                <x-form.input
                                    name="firstname"
                                    type="text"
                                    label="Nom" />

                                <x-form.input
                                    name="lastname"
                                    type="text"
                                    label="Prénom" />
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
    <div
        id="drawer_beneficiaire"

        class="bg-white"
        data-kt-drawer="true"
        data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#kt_drawer_example_dismiss_button"
        data-kt-drawer-close="#kt_drawer_example_dismiss_close"
        data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'300px', 'md': '500px'}"
    >
        <div class="card shadow-sm w-100">
            <div class="card-body">
                <div class="d-flex flex-column mb-5">
                    <span class="fs-6">IBAN</span>
                    <span class="fw-bolder fs-3" data-control="iban"></span>
                </div>
                <div class="d-flex flex-column mb-5">
                    <span class="fs-6">Nom du bénéficiaire</span>
                    <span class="fw-bolder fs-3" data-control="name"></span>
                </div>
                <div class="d-flex flex-column mb-5">
                    <span class="fs-6">Banque</span>
                    <span class="fw-bolder fs-3" data-control="banque"></span>
                </div>
                <div class="d-flex flex-column mb-5">
                    <span class="fs-6">Je suis titulaire du compte</span>
                    <span class="fw-bolder fs-3" data-control="titulaire"></span>
                </div>
            </div>
            <div class="card-footer d-flex flex-wrap w-100">
                <button class="btn btn-bank w-100 mb-2 edit" data-beneficiaire="">Modifier</button>
                <button class="btn btn-outline btn-outline-bank w-100 mb-2 delete" data-beneficiaire="">Supprimer</button>
                <button class="btn btn-outline btn-outline-bank w-100 mb-2 transfer" data-beneficiaire="">Faire un virement</button>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.transfer.beneficiaire")
@endsection
