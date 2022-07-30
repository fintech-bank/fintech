@extends("front.layouts.layout")

@section("css")

@endsection

@section("content")
    <div class="mb-n10 mb-lg-n20 z-index-2">
        <!--begin::Container-->
        <div class="container">
            <div class="card" id="kt_pricing">
                <!--begin::Card body-->
                <div class="card-body p-lg-17">
                    <!--begin::Plans-->
                    <div class="d-flex flex-column">
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <h1 class="fs-2hx fw-bold mb-5">Choisissez l’expérience qui vous correspond</h1>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Nav group-->
                        <div class="nav nav-group nav-group-outline mx-auto mb-15" data-kt-buttons="true" data-kt-initialized="1">
                            <button class="nav-link btn btn-color-gray-400 btn-active btn-active-success px-6 py-3 me-2 active" data-bs-toggle="tab" href="#particulier">Particulier</button>
                            <button class="nav-link btn btn-color-gray-400 btn-active btn-active-danger px-6 py-3" data-bs-toggle="tab" href="#pro">Professionnel</button>
                        </div>
                        <!--end::Nav group-->
                        <div class="tab-content" id="tabPricing">
                            <div class="tab-pane fade show active" id="particulier" role="tabpanel">
                                <!--begin::Row-->
                                <div class="row g-10">
                                    @foreach(\App\Models\Core\Package::where('type_cpt', 'part')->get() as $package)
                                        <!--begin::Col-->
                                        <div class="col">
                                            <div class="d-flex h-100 align-items-center">
                                                <!--begin::Option-->
                                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                                    <!--begin::Heading-->
                                                    <div class="mb-7 text-center">
                                                        <!--begin::Title-->
                                                        <h1 class="text-dark mb-5 fw-bolder">{{ $package->name }}</h1>
                                                        <!--end::Title-->
                                                        <!--begin::Price-->
                                                        <div class="text-center">
                                                            <span class="mb-2 text-primary"><i class="fa-solid fa-euro-sign text-primary"></i></span>
                                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">{{ $package->price }}</span>
                                                            <span class="fs-7 fw-semibold opacity-50">/<span data-kt-element="period">mois</span></span>
                                                        </div>
                                                        <!--end::Price-->
                                                    </div>
                                                    <!--end::Heading-->
                                                    <!--begin::Features-->
                                                    <div class="w-100 mb-10">
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
                                                    <!--end::Features-->
                                                    <!--begin::Select-->
                                                    <a href="{{ route('register.cart', ["package" => $package->id]) }}" class="btn btn-sm btn-bank">Choisir le compte {{ $package->name }}</a>
                                                    <!--end::Select-->
                                                </div>
                                                <!--end::Option-->
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    @endforeach
                                </div>
                                <!--end::Row-->
                            </div>
                            <div class="tab-pane fade" id="pro" role="tabpanel">
                                <!--begin::Row-->
                                <div class="row g-10">
                                    @foreach(\App\Models\Core\Package::where('type_cpt', 'pro')->get() as $package)
                                        <!--begin::Col-->
                                        <div class="col">
                                            <div class="d-flex h-100 align-items-center">
                                                <!--begin::Option-->
                                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                                    <!--begin::Heading-->
                                                    <div class="mb-7 text-center">
                                                        <!--begin::Title-->
                                                        <h1 class="text-dark mb-5 fw-bolder">{{ $package->name }}</h1>
                                                        <!--end::Title-->
                                                        <!--begin::Price-->
                                                        <div class="text-center">
                                                            <span class="mb-2 text-primary"><i class="fa-solid fa-euro-sign text-primary"></i></span>
                                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">{{ $package->price }}</span>
                                                            <span class="fs-7 fw-semibold opacity-50">/<span data-kt-element="period">mois</span></span>
                                                        </div>
                                                        <!--end::Price-->
                                                    </div>
                                                    <!--end::Heading-->
                                                    <!--begin::Features-->
                                                    <div class="w-100 mb-10">
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
                                                    <!--end::Features-->
                                                    <!--begin::Select-->
                                                    <a href="{{ route('register.cart', ["package" => $package->id]) }}" class="btn btn-sm btn-bank">Choisir le compte {{ $package->name }}</a>
                                                    <!--end::Select-->
                                                </div>
                                                <!--end::Option-->
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    @endforeach
                                </div>
                                <!--end::Row-->
                            </div>
                        </div>

                    </div>
                    <!--end::Plans-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--begin::Heading-->

@endsection

@section("script")

@endsection
