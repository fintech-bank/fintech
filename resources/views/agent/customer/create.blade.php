@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Création d'un compte client</h1>
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
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.index') }}" class="text-muted text-hover-primary">Clients</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Création d'un compte client</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="d-flex flex-row justify-content-center mb-10">
        <!--begin::Option-->
        <input type="radio" class="btn-check" name="type" value="part" id="kt_radio_buttons_2_option_1" onchange="getTypeAccount()" />
        <label class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center mb-5 me-5" for="kt_radio_buttons_2_option_1">
            <!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
            <i class="fa-solid fa-users-viewfinder me-4 fa-4x"></i>
            <!--end::Svg Icon-->

            <span class="d-block fw-bold text-start">
                <span class="text-dark fw-bolder d-block fs-3">Compte Particulier</span>
                <span class="text-muted fw-bold fs-6">
                    Comptes bancaire individual
                </span>
            </span>
        </label>
        <!--end::Option-->

        <!--begin::Option-->
        <input type="radio" class="btn-check" name="type" value="pro" id="kt_radio_buttons_2_option_2" onchange="getTypeAccount()" />
        <label class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center" for="kt_radio_buttons_2_option_2">
            <i class="fa-solid fa-building me-4 fa-4x"></i>

            <span class="d-block fw-bold text-start">
                <span class="text-dark fw-bolder d-block fs-3">Compte Professionnel</span>
                <span class="text-muted fw-bold fs-6">Compte professionel pour entreprise ou auto entrepreneur</span>
            </span>
        </label>
        <!--end::Option-->
    </div>
    <div class="card shadow-lg">
        <div class="card-body">
            <div id="part">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="stepper_part">
                    <!--begin::Aside-->
                    <div class="d-flex flex-row-auto w-100 w-lg-300px flex-center">
                        <!--begin::Nav-->
                        <div class="stepper-nav">
                            <!--begin::Step 1-->
                            <div class="stepper-item me-5 current" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->

                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <!--end::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Informations Personnel
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 1-->

                            <!--begin::Step 2-->
                            <div class="stepper-item me-5" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->

                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <!--begin::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Informations Professionnel
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 2-->

                            <!--begin::Step 3-->
                            <div class="stepper-item me-5" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->

                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">3</span>
                                </div>
                                <!--begin::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Offres
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 3-->

                            <!--begin::Step 4-->
                            <div class="stepper-item me-5" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->

                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">4</span>
                                </div>
                                <!--begin::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Récapitulatif
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 4-->
                        </div>
                        <!--end::Nav-->
                    </div>

                    <!--begin::Content-->
                    <div class="flex-row-fluid flex-center">
                        <!--begin::Form-->
                        <form id="formAddCustomerPart" action="{{ route('agent.customer.store') }}" class="form w-lg-1000px mx-auto" novalidate="novalidate" method="post">
                            @csrf
                            <input type="hidden" name="type" value="part">
                            <!--begin::Group-->
                            <div class="mb-5">
                                <!--begin::Step 1-->
                                <div class="flex-column current" data-kt-stepper-element="content">
                                    <div class="mb-10 d-flex flex-row">
                                        <x-form.radio
                                            name="civility"
                                            value="M"
                                            for="civilityM"
                                            label="Monsieur" />

                                        <x-form.radio
                                            name="civility"
                                            value="Mme"
                                            for="civilityMme"
                                            label="Madame" />

                                        <x-form.radio
                                            name="civility"
                                            value="Mlle"
                                            for="civilityMlle"
                                            label="Mademoiselle" />
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <x-form.input
                                                name="lastname"
                                                type="text"
                                                label="Nom de famille"
                                                required="true" />
                                        </div>
                                        <div class="col-4">
                                            <x-form.input
                                                name="middlename"
                                                type="text"
                                                label="Nom Marital"
                                                required="false" />
                                        </div>
                                        <div class="col-4">
                                            <x-form.input
                                                name="firstname"
                                                type="text"
                                                label="Prénom"
                                                required="true" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <x-form.input-date
                                                name="datebirth"
                                                type="text"
                                                label="Date de naissance"
                                                required="true" />
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-10">
                                                <label for="countrybirth" class="required form-label">
                                                    Pays de Naissance
                                                </label>
                                                <select id="countrybirth" class="form-select form-select-solid" data-placeholder="Selectionnez un pays de naissance" name="countrybirth" onchange="citiesFromCountry(this)">
                                                    <option value=""></option>
                                                    @foreach(\App\Helper\GeoHelper::getAllCountries() as $data)
                                                        <option value="{{ $data->name }}" data-kt-select2-country="{{ $data->flag }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-10" id="divCities"></div>
                                        </div>
                                    </div>
                                    <x-base.underline title="Adresse Postal" size="3" sizeText="fs-1" color="bank"/>
                                    <x-form.input
                                        name="address"
                                        type="text"
                                        label="Adresse Postal"
                                        required="true" />
                                    <x-form.input
                                        name="addressbis"
                                        type="text"
                                        label="Complément d'adresse" />

                                    <div class="row">
                                        <div class="col-4">
                                            <x-form.input
                                                name="postal"
                                                type="text"
                                                label="Code Postal"
                                                required="true" />
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-10" id="divCity"></div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-10">
                                                <label for="country" class="required form-label">
                                                    Pays de résidence
                                                </label>
                                                <select id="country" class="form-select form-select-solid" data-placeholder="Selectionnez un pays" name="country">
                                                    <option value=""></option>
                                                    @foreach(\App\Helper\GeoHelper::getAllCountries() as $data)
                                                        <option value="{{ $data->name }}" data-kt-select2-country="{{ $data->flag }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <x-base.underline title="Contact" size="3" sizeText="fs-1" color="bank" />
                                    <div class="row">
                                        <div class="col-4">
                                            <x-form.input
                                                name="phone"
                                                type="text"
                                                label="Domicile" text="Format: +33999999999"/>
                                        </div>
                                        <div class="col-4">
                                            <x-form.input
                                                name="mobile"
                                                type="text"
                                                label="Mobile"
                                                text="Format: +33999999999"
                                                required="true" />
                                        </div>
                                        <div class="col-4">
                                            <x-form.input
                                                name="email"
                                                type="email"
                                                label="Adresse Mail"
                                                required="true" />
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Step 1-->

                                <!--begin::Step 1-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    <x-base.underline title="Situation Personnel" size="3" sizeText="fs-1" color="bank" />
                                    <div class="row">
                                        <div class="col-6">
                                            <x-form.select
                                                name="legal_capacity"
                                                :datas="\App\Helper\CustomerSituationHelper::dataLegalCapacity()"
                                                label="Capacité Juridique" required="false"/>
                                        </div>
                                        <div class="col-6">
                                            <x-form.select
                                                name="family_situation"
                                                :datas="\App\Helper\CustomerSituationHelper::dataFamilySituation()"
                                                label="Situation Familiale" required="false"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <x-form.select
                                                name="logement"
                                                :datas="\App\Helper\CustomerSituationHelper::dataLogement()"
                                                label="Dans votre logement, vous êtes" required="false"/>
                                        </div>
                                        <div class="col-6">
                                            <x-form.input-date
                                                name="logement_at"
                                                type="text"
                                                label="Depuis le" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <x-form.input-dialer
                                                name="child"
                                                label="Nombre d'enfant"
                                                min="0"
                                                max="99"
                                                step="1"
                                                value="0" />
                                        </div>
                                        <div class="col-6">
                                            <x-form.input-dialer
                                                name="person_charged"
                                                label="Nombre de personne à charge"
                                                min="0"
                                                max="99"
                                                step="1"
                                                value="0" />
                                        </div>
                                    </div>
                                    <x-base.underline title="Situation Professionnel" size="3" sizeText="fs-1" color="bank" />
                                    <x-form.select
                                        name="pro_category"
                                        :datas="\App\Helper\CustomerSituationHelper::dataProCategories()"
                                        label="Catégorie sociaux Professionnel" />

                                    <x-form.input
                                        name="pro_profession"
                                        type="text"
                                        label="Profession" />

                                    <x-base.underline title="Revenue" size="3" sizeText="fs-1" color="bank" />
                                    <div class="row">
                                        <div class="col-6">
                                            <x-form.input-group
                                                name="pro_incoming"
                                                label="Revenue Professionnel"
                                                placement="left"
                                                symbol="€" />
                                        </div>
                                        <div class="col-6">
                                            <x-form.input-group
                                                name="patrimoine"
                                                label="Patrimoine"
                                                placement="left"
                                                symbol="€" />
                                        </div>
                                    </div>
                                    <x-base.underline title="Charges" size="3" sizeText="fs-1" color="bank" />
                                    <div class="row">
                                        <div class="col-6">
                                            <x-form.input-group
                                                name="rent"
                                                label="Loyer, mensualité crédit immobilier"
                                                placement="left"
                                                symbol="€" />
                                        </div>
                                        <div class="col-6">
                                            <x-form.input-group
                                                name="divers"
                                                label="Charges Divers (pension, etc...)"
                                                placement="left"
                                                symbol="€" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <x-form.input
                                                name="nb_credit"
                                                type="text"
                                                label="Nombre de crédit (Crédit Personnel, Renouvelable, etc...)" />
                                        </div>
                                        <div class="col-6">
                                            <x-form.input-group
                                                name="credit"
                                                label="Mensualité de vos crédits"
                                                placement="left"
                                                symbol="€" />
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Step 1-->

                                <!--begin::Step 1-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    <x-base.underline title="Compte bancaire" size="3" sizeText="fs-1" color="bank" />
                                    <div class="mb-10">
                                        <label for="package_id" class="required form-label">
                                            Plan de compte
                                        </label>
                                        <select id="package_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Selectionner un plan" name="package_id" required>
                                            <option value=""></option>
                                            @foreach(\App\Models\Core\Package::all() as $package)
                                                <option value="{{ $package->id }}">{{ $package->name }} - {{ eur($package->price) }} / par mois</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <x-base.underline title="Carte Bancaire" size="3" sizeText="fs-1" color="bank" />
                                    <div class="mb-10">
                                        <label for="card_support" class="required form-label">
                                            Type de carte bancaire
                                        </label>
                                        <select id="card_support" class="form-select form-select-solid" data-placeholder="Selectionner un type de carte" name="card_support" required>
                                            <option value=""></option>
                                            <option value="classic" data-card-img="/storage/card/classic.png">Visa Classic</option>
                                            <option value="premium" data-card-img="/storage/card/premium.png">Visa Gold</option>
                                            <option value="infinite" data-card-img="/storage/card/infinite.png">Visa Infinity</option>
                                        </select>
                                    </div>
                                    <div class="mb-10">
                                        <label for="card_debit" class="required form-label">
                                            Type de débit
                                        </label>
                                        <select id="card_debit" class="form-select form-select-solid" data-control="select2" data-placeholder="Selectionner un type de débit" name="card_debit" required>
                                            <option value=""></option>
                                            <option value="immediate">Débit immédiat</option>
                                            <option value="differed">Débit Différé</option>
                                        </select>
                                    </div>
                                    <x-form.checkbox
                                        name="decouvert"
                                        value=""
                                        label="Demander une possibilité de découvert bancaire" />
                                </div>
                                <!--begin::Step 1-->

                                <!--begin::Step 1-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    <x-base.underline title="Récapitulatif " size="3" sizeText="fs-1" color="bank" />
                                    <x-base.underline title="Informations personnelles" size="3" sizeText="fs-2" color="bank" />
                                    <div class="d-flex flex-row flex-stack mb-10">
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Civilité</div>
                                            <div class="fs-3 fw-bold" id="recap_civility">M.</div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Prénom</div>
                                            <div class="fs-3 fw-bold" id="recap_lastname">Maxime</div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Nom marital</div>
                                            <div class="fs-3 fw-bold" id="recap_middlename"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Nom</div>
                                            <div class="fs-3 fw-bold" id="recap_firstname">Mockelyn</div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row flex-stack mb-10">
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Email</div>
                                            <div class="fs-3 fw-bold" id="recap_email">test@test.com</div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Domicile</div>
                                            <div class="fs-3 fw-bold" id="recap_phone">test@test.com</div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Mobile</div>
                                            <div class="fs-3 fw-bold" id="recap_mobile">test@test.com</div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row flex-stack mb-10">
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Adresse Postal</div>
                                            <div class="fs-3 fw-bold" id="recap_address">22 Rue Maryse Bastié, 85100 Les Sables d'Olonne, France</div>
                                        </div>
                                    </div>
                                    <x-base.alert
                                        type="light"
                                        color="primary"
                                        icon="info"
                                        title="Information importante"
                                        content="Vous devez absolument demander au client un justificatif de domicile pour l'adresse déclarer" />

                                    <x-base.underline title="Offre Proposer" size="3" sizeText="fs-2" color="bank" />
                                    <x-base.underline title="Compte Bancaire" size="2" sizeText="fs-3" color="bank" />
                                    <div class="d-flex flex-row flex-stack mb-10">
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Plan choisie</div>
                                            <div class="fs-3 fw-bold" id="recap_plan">Pack Crystal</div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Montant par mois</div>
                                            <div class="fs-3 fw-bold" id="recap_plan_price">0,00 € par mois</div>
                                        </div>
                                    </div>
                                    <div class="separator border-bank"></div>
                                    <x-base.underline title="Carte Bancaire" size="2" sizeText="fs-3" color="bank" />
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-100px symbol-2by3 me-5">
                                            <img src="/storage/card/classic.png" class="" alt="">
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Text-->
                                        <div class="flex-grow-1">
                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Carte Visa Classic avec assurance et assiatnces incluses</a>
                                            <span class="text-muted d-block fw-bold">Fourniture d'une carte de débit (carte de paiement à débit différé)</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <div class="d-flex flex-row flex-stack mb-10">
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Type de débit</div>
                                            <div class="fs-3 fw-bold" id="recap_card_debit">Différé</div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row flex-stack mb-10">
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Paiement par carte / 30 jours</div>
                                            <div class="fs-3 fw-bold" id="recap_card_limit_payment">1 200,00 €</div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fs-6 text-muted">Retrait par carte / 7 jours</div>
                                            <div class="fs-3 fw-bold" id="recap_card_limit_retrait">500,00 €</div>
                                        </div>
                                    </div>
                                    <div class="separator border-bank"></div>
                                    <x-base.underline title="Découvert Bancaire" size="2" sizeText="fs-3" color="bank" />
                                    <div class="d-flex flex-row">
                                        <i class="fa-solid fa-check-circle text-success fa-lg me-2"></i> Vous avez demander la possibilité d'avoir un découvert bancaire
                                    </div>
                                </div>
                                <!--begin::Step 1-->
                            </div>
                            <!--end::Group-->

                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                        Retour
                                    </button>
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Wrapper-->
                                <div>
                                    <button type="submit" class="btn btn-bank" data-kt-stepper-action="submit">
                        <span class="indicator-label">
                            Soumettre
                        </span>
                                        <span class="indicator-progress">
                            Veuillez patienter... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                                    </button>

                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                        Suivant
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Stepper-->
            </div>
            <div id="pro">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="stepper_pro">
                    <!--begin::Aside-->
                    <div class="d-flex flex-row-auto w-100 w-lg-300px flex-center">
                        <!--begin::Nav-->
                        <div class="stepper-nav">
                            <!--begin::Step 1-->
                            <div class="stepper-item me-5 current" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->

                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <!--end::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Informations Personnel
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 1-->

                            <!--begin::Step 2-->
                            <div class="stepper-item me-5" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->

                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <!--begin::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Informations Professionnel
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 2-->

                            <!--begin::Step 3-->
                            <div class="stepper-item me-5" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->

                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">3</span>
                                </div>
                                <!--begin::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Offres
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 3-->

                            <!--begin::Step 4-->
                            <div class="stepper-item me-5" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->

                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">4</span>
                                </div>
                                <!--begin::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Récapitulatif
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 4-->
                        </div>
                        <!--end::Nav-->
                    </div>

                    <!--begin::Content-->
                    <div class="flex-row-fluid flex-center">
                        <!--begin::Form-->
                        <form action="{{ route('agent.customer.store') }}" class="form w-lg-500px mx-auto" novalidate="novalidate" method="post">
                            <!--begin::Group-->
                            <div class="mb-5">
                                <!--begin::Step 1-->
                                <div class="flex-column current" data-kt-stepper-element="content">

                                </div>
                                <!--begin::Step 1-->

                                <!--begin::Step 1-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label">Example Label 1</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="input1" placeholder="" value=""/>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label">Example Label 2</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <textarea class="form-control form-control-solid" rows="3" name="input2" placeholder=""></textarea>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label">Example Label 3</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" checked="checked" type="checkbox" value="1"/>
                                            <span class="form-check-label">
                                Checkbox
                            </span>
                                        </label>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--begin::Step 1-->

                                <!--begin::Step 1-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label d-flex align-items-center">
                                            <span class="required">Input 1</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Example tooltip"></i>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="input1" placeholder="" value=""/>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label">
                                            Input 2
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="input2" placeholder="" value=""/>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--begin::Step 1-->

                                <!--begin::Step 1-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label d-flex align-items-center">
                                            <span class="required">Input 1</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Example tooltip"></i>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="input1" placeholder="" value=""/>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label">
                                            Input 2
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="input2" placeholder="" value=""/>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label">
                                            Input 3
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="input3" placeholder="" value=""/>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--begin::Step 1-->
                            </div>
                            <!--end::Group-->

                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                        Back
                                    </button>
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Wrapper-->
                                <div>
                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="submit">
                        <span class="indicator-label">
                            Submit
                        </span>
                                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                                    </button>

                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                        Continue
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Stepper-->
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.create")
@endsection
