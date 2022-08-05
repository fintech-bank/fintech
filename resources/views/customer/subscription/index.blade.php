@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Souscription</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('customer.dashboard') }}" class="text-muted text-hover-primary">{{ \App\Helper\CustomerHelper::getName($customer) }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Souscriptions</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->

    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="card card-flush shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#subscription">Souscriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#requests">Mes Demandes</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body py-5 tab-content">
            <div class="tab-pane fade show active" id="subscription" role="tabpanel">
                <h1 class="d-flex flex-row align-items-center fw-lighter mb-5">
                    <i class="fa-solid fa-credit-card me-3"></i>
                    Comptes & moyens de paiements
                </h1>

                <div class="row">
                    <div class="col-4">
                        <a href="#UpdateAccount" data-bs-toggle="modal" class="card card-flush shadow-sm bg-hover-secondary text-hover-white">
                            <div class="card-body d-flex flex-row text-dark ">
                                <img src="https://source.unsplash.com/random/300x300/?bank" alt="" class="w-25 me-3">
                                <div class="w-75">
                                    <span class="fw-bolder fs-3">Forfaits Bancaires</span><br>
                                    <span class="fs-6 fw-lighter"> Réalisez une simulation pour choisir le forfait adapté à vos besoins. </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="#MobilityAccount" data-bs-toggle="modal" class="card card-flush shadow-sm bg-hover-secondary text-hover-white">
                            <div class="card-body d-flex flex-row text-dark ">
                                <img src="https://source.unsplash.com/random/300x300/?mobile" alt="" class="w-25 me-3">
                                <div class="w-75">
                                    <span class="fw-bolder fs-3">Mobilité Bancaire</span><br>
                                    <span class="fs-6 fw-lighter"> Regroupez vos comptes. Accompagnement gratuit dans votre changement de banque. </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="separator my-10"></div>

                <h1 class="d-flex flex-row align-items-center fw-lighter mb-5">
                    <i class="fa-solid fa-hand-holding-dollar me-3"></i>
                    Emprunter
                </h1>

                <div class="row">
                    <div class="col-4">
                        <a href="" class="card card-flush shadow-sm bg-hover-secondary text-hover-white">
                            <div class="card-body d-flex flex-row text-dark ">
                                <img src="https://source.unsplash.com/random/300x300/?loan" alt="" class="w-25 me-3">
                                <div class="w-75">
                                    <span class="fw-bolder fs-3">Pret Personnel</span><br>
                                    <span class="fs-6 fw-lighter"> Simulez le financement de tous vos projets.</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="" class="card card-flush shadow-sm bg-hover-secondary text-hover-white">
                            <div class="card-body d-flex flex-row text-dark ">
                                <img src="https://source.unsplash.com/random/300x300/?building" alt="" class="w-25 me-3">
                                <div class="w-75">
                                    <span class="fw-bolder fs-3">Crédit Immobilier</span><br>
                                    <span class="fs-6 fw-lighter">Réalisez votre demande de crédit immobilier et recevez une réponse personnalisé</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="" class="card card-flush shadow-sm bg-hover-secondary text-hover-white">
                            <div class="card-body d-flex flex-row text-dark ">
                                <img src="https://source.unsplash.com/random/300x300/?human" alt="" class="w-25 me-3">
                                <div class="w-75">
                                    <span class="fw-bolder fs-3">Crédit Renouvelable FACELIA</span><br>
                                    <span class="fs-6 fw-lighter">Au comptant ou à crédit, gérez vos dépense à votre rythme</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="separator my-10"></div>

                <h1 class="d-flex flex-row align-items-center fw-lighter mb-5">
                    <i class="fa-solid fa-hand-holding-dollar me-3"></i>
                    Epargner
                </h1>

                <div class="row">
                    <div class="col-4">
                        <a href="" class="card card-flush shadow-sm bg-hover-secondary text-hover-white">
                            <div class="card-body d-flex flex-row text-dark ">
                                <img src="https://source.unsplash.com/random/300x300/?Saving" alt="" class="w-25 me-3">
                                <div class="w-75">
                                    <span class="fw-bolder fs-3">Livret A</span><br>
                                    <span class="fs-6 fw-lighter"> Solution d'épargne stable, sécurisé et disponible</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="" class="card card-flush shadow-sm bg-hover-secondary text-hover-white">
                            <div class="card-body d-flex flex-row text-dark ">
                                <img src="https://source.unsplash.com/random/300x300/?family" alt="" class="w-25 me-3">
                                <div class="w-75">
                                    <span class="fw-bolder fs-3">Assurance Vie</span><br>
                                    <span class="fs-6 fw-lighter"> Parce que vos projets évoluent tout au long de votre vie, il est important de les préparer au mieux. </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="" class="card card-flush shadow-sm bg-hover-secondary text-hover-white">
                            <div class="card-body d-flex flex-row text-dark ">
                                <img src="https://source.unsplash.com/random/300x300/?civil" alt="" class="w-25 me-3">
                                <div class="w-75">
                                    <span class="fw-bolder fs-3">LLDS</span><br>
                                    <span class="fs-6 fw-lighter"> Une épargne sécurisée et disponible au service de projets citoyens.  </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="requests" role="tabpanel">
                ...
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="UpdateAccount">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Changement d'offre</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formUpdateAccount" action="{{ route('customer.subscription.update-account') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-10">
                            <!--begin::Col-->
                            <div class="col-lg-6 mb-10 mb-lg-0">
                                <!--begin::Tabs-->
                                <div class="nav flex-column" role="tablist">
                                    @foreach(\App\Models\Core\Package::where('type_cpt', 'part')->get() as $package)
                                        <!--begin::Tab link-->
                                        <label class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 @if($customer->package->name == $package->name) active @endif mb-6" data-bs-toggle="tab" data-bs-target="#{{ Str::camel($package->name) }}" aria-selected="true" role="tab">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
                                                    <input class="form-check-input" type="radio" name="package" @if($customer->package->name == $package->name) checked="checked" @endif value="{{ $package->id }}">
                                                </div>
                                                <!--end::Radio-->
                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center fs-2 fw-bold flex-wrap">
                                                        Pack {{ $package->name }}</div>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Description-->
                                            <!--begin::Price-->
                                            <div class="ms-5">
                                                <span class="mb-2">€</span>
                                                <span class="fs-3x fw-bold" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">{{ eur($package->price) }}</span>
                                                <span class="fs-7 opacity-50">/
												<span data-kt-element="period">par mois</span></span>
                                            </div>
                                            <!--end::Price-->
                                        </label>
                                        <!--end::Tab link-->
                                    @endforeach
                                </div>
                                <!--end::Tabs-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <!--begin::Tab content-->
                                <div class="tab-content rounded h-100 bg-light p-10">
                                    @foreach(\App\Models\Core\Package::where('type_cpt', 'part')->get() as $package)
                                    <!--begin::Tab Pane-->
                                    <div class="tab-pane fade @if($customer->package->name == $package->name) show active @endif" id="{{ Str::camel($package->name) }}" role="tabpanel">
                                        <!--begin::Heading-->
                                        <div class="pb-5">
                                            <h2 class="fw-bold text-dark">Pack {{ $package->name }}</h2>
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Body-->
                                        <div class="pt-1">
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Carte de Paiement VISA</span>
                                                @if($package->visa_classic == 1)
                                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Dépot de chèque</span>
                                                @if($package->check_deposit == 1)
                                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Paiement & Retrait</span>
                                                @if($package->payment_withdraw == 1)
                                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Facilité de caisse</span>
                                                @if($package->overdraft == 1)
                                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Dépot d'espèce</span>
                                                @if($package->cash_deposit == 1)
                                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Retrait à l'internationnal</span>
                                                @if($package->withdraw_international == 1)
                                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Paiement à l'internationnal</span>
                                                @if($package->payment_international == 1)
                                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Assurance des paiement par carte bancaire</span>
                                                @if($package->payment_insurance == 1)
                                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Chéquier</span>
                                                @if($package->check == 1)
                                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Nombre de carte physique</span>
                                                <span class="fs-6 text-gray-600">{{ $package->nb_carte_physique }}</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Nombre de carte Virtuel</span>
                                                <span class="fs-6 text-gray-600">{{ $package->nb_carte_virtuel }}</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Sous comptes</span>
                                                @if($package->subaccount == 1)
                                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Tab Pane-->
                                    @endforeach
                                </div>
                                <!--end::Tab content-->
                            </div>
                            <!--end::Col-->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="MobilityAccount">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow-none">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Demande de mobilité bancaire</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formMobilityAccount" action="{{ route('customer.subscription.mobility') }}" method="POST">
                    @csrf
                    <div class="modal-body m-0 p-0">
                        <div class="card border-transparent rounded-0 bg-bank mb-10" data-theme="light">
                            <!--begin::Body-->
                            <div class="card-body d-flex align-items-center ps-xl-15 h-300px">
                                <!--begin::Wrapper-->
                                <div class="m-0 w-450px">
                                    <!--begin::Title-->
                                    <div class="position-relative fs-4x z-index-2 fw-bold text-white mb-7">
                                        Mobilité Bancaire
                                    </div>
                                    <span class="text-white fs-3">Tout savoir sur la mobilité bancaire, avec la mise à disposition d'un dispositif gratuit pour devenir client {{ config('app.name') }}.</span>
                                    <!--end::Title-->
                                </div>
                                <!--begin::Wrapper-->
                                <!--begin::Illustration-->
                                <img src="https://source.unsplash.com/random/1920x1080/?mobile" class="position-absolute me-3 bottom-10 end-0 h-100" alt="">
                                <!--end::Illustration-->
                            </div>
                            <!--end::Body-->
                        </div>

                        <div class="container mb-10">
                            <div class="fs-2x fw-bolder">Vous souhaitez effectuer un transfert de compte ?</div>
                            <p class="fw-lighter">Nous vous proposons, gratuitement et sans condition, notre service d’accompagnement à la mobilité bancaire Facili’Pop. Il vous suffit de nous donner mandat et nous effectuons pour vous les formalités liées au changement de compte, afin que vos prélèvements valides et virements récurrents se présentent sur votre nouveau compte
                                {{ config('app.name') }}. Vous suivez gratuitement en ligne* l’avancement de votre dossier de mobilité et pouvez le compléter sur un site Internet dédié sécurisé.</p>
                        </div>
                        <div class="container mb-10">
                            <div class="fs-2x fw-bolder">FACILI’POP, ACCOMPAGNEMENT DANS LA MOBILITE BANCAIRE, ETAPE PAR ETAPE :</div>
                            <div class="d-flex flex-column">
                                <li class="d-flex align-items-center py-2">
                                    <span class="bullet bullet-dot me-5"></span> <strong>Etape 1:</strong>&nbsp; Vous signez un mandat dans votre agence
                                    {{ config('app.name') }} (banque d’arrivée) et remettez à votre conseiller un Relevé d’Identité Bancaire de la banque que vous quittez (banque de départ)
                                </li>
                                <li class="d-flex py-2">
                                    <span class="bullet bullet-dot bg-danger me-5"></span> <strong>Etape 2:</strong>&nbsp; dans les deux jours ouvrés après la signature du mandat, {{ config('app.name') }} sollicite de votre banque de départ :
                                    <ul>
                                        <li>les informations relatives aux mandats de prélèvements valides et aux virements récurrents ayant transité sur votre compte au cours des treize mois précédents,</li>
                                        <li>La liste des numéros de formule de chèques non débitées sur les chéquiers utilisés au cours des treize mois précédents,</li>
                                        <li>L’arrêt des virements permanents émis.</li>
                                    </ul>
                                    Si vous le souhaitez, nous pouvons également demander à l’établissement de départ la clôture de votre compte et le virement du solde positif vers votre nouveau compte {{ config('app.name') }}.
                                </li>
                                <li class="d-flex align-items-center py-2">
                                    <span class="bullet bullet-dot bg-success me-5"></span> <strong>Etape 3:</strong>&nbsp; la banque de départ répond dans les cinq jours ouvrés à compter de la demande de {{ config('app.name') }}. Vous pouvez, dès réception des informations par {{ config('app.name') }}, les consulter sur le site Facili’Pop avec vos identifiants et codes personnels : vous en serez averti(e) et nous vous inviterons à vérifier la complétude des ses informations sous 48 h.
                                </li>
                                <li class="d-flex align-items-center py-2">
                                    <span class="bullet bullet-dot bg-info me-5"></span> <strong>Etape 4:</strong>&nbsp; {{ config('app.name') }} communique enfin les coordonnées de votre nouveau compte aux banques des émetteurs de prélèvements valides et de virements récurrents mentionnés par votre banque de départ, dans les deux jours ouvrés après la réception des informations fournies par cette dernière. Ces banques les transmettent ensuite aux émetteurs dans un délai de trois jours ouvrés suivant la réception des informations de la part de la banque d’arrivée.
                                </li>
                                <li class="d-flex align-items-center py-2">
                                    <span class="bullet bullet-dot bg-primary me-5"></span> <strong>A noter:</strong>&nbsp; Ouvrir un compte de dépôt à {{ config('app.name') }}, c’est aussi pouvoir choisir parmi la liste mise à disposition sur le site Internet sécurisé Facili’Pop*, les émetteurs à informer de votre changement de coordonnées bancaires. Cette option pourra être choisie dès la signature du mandat de mobilité.
                                </li>
                            </div>
                        </div>

                        <div class="m-5 p-5">
                            <x-base.underline title="Formulaire de demande de mobilité bancaire" class="w-100 mb-10"/>

                            <x-form.input
                                name="old_iban"
                                type="text"
                                label="Ancien Compte"
                                placeholder="Iban de l'ancien compte" required="true" />

                            <div class="mb-10">
                                <label for="" class="form-label">Ancienne Banque</label>
                                <select class="form-select form-select-solid" data-control="select2" name="old_bic" data-dropdown-parent="#MobilityAccount" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach(\App\Models\Core\Bank::all() as $bank)
                                        <option value="{{ $bank->bic }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <x-form.input-date
                                name="end_prlv"
                                type="text"
                                label="Date d'arret des virements permanents"
                                required="true" />

                            <div class="d-flex flex-row w-200px mb-10">
                                <label for="" class="form-label me-5">Cloturer le compte</label>
                                <x-form.radio
                                    name="close_account"
                                    value="1"
                                    for="close_account"
                                    label="Oui"
                                    checked="checked" />

                                <x-form.radio
                                    name="close_account"
                                    value="0"
                                    for="close_account"
                                    label="Non" />

                            </div>

                            <div class="mb-10">
                                <label for="customer_wallet_id" class="form-label required">Nouveau Compte</label>
                                <select class="form-select form-select-solid" data-control="select2" name="customer_wallet_id" data-dropdown-parent="#MobilityAccount" data-placeholder="Select an option" data-allow-clear="true" required>
                                    <option></option>
                                    @foreach($customer->wallets()->where('status', 'active')->where('type', 'compte')->get() as $wallet)
                                        <option value="{{ $wallet->id }}">{{ \App\Helper\CustomerWalletHelper::getNameAccount($wallet) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-form.button
                           text="Demander la mobilité bancaire" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="MobilitySignate">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Mandat de mobilité bancaire</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formMobilitySignate" action="{{ route('customer.subscription.mobilitySignate') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-base.alert
                            type=""
                            color="primary"
                            icon="info"
                            title="Signature de document Obligatoire"
                            content="Un SMS de vérification vous à été envoyer par SMS au {{ $customer->info->mobile }} afin de signer un document." />

                        <x-form.input
                            name="code"
                            type="text"
                            label="Code de vérification"
                            required="true" />


                        <div id="viewerMobility" class="h-1000px w-100" data-document=""></div>
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
    <script src="/assets/plugins/custom/pdfexpress/lib/webviewer.min.js" type="text/javascript"></script>
    @include("customer.scripts.subscription.index")
@endsection
