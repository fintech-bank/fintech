@extends("front.layouts.layout")

@section("css")

@endsection

@section("content")
    <div class="mb-n10 mb-lg-n20 z-index-2">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Stepper-->
            <div class="stepper stepper-pills" id="kt_stepper_example_basic">
                <!--begin::Nav-->
                <div class="stepper-nav flex-center flex-wrap mb-10">
                    <!--begin::Step 1-->
                    <div class="stepper-item mx-8 my-4 completed" data-kt-stepper-element="nav">
                        <!--begin::Wrapper-->
                        <div class="stepper-wrapper d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">1</span>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">
                                    Choix de l'offre
                                </h3>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Line-->
                        <div class="stepper-line h-40px"></div>
                        <!--end::Line-->
                    </div>
                    <!--end::Step 1-->

                    <!--begin::Step 2-->
                    <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                        <!--begin::Wrapper-->
                        <div class="stepper-wrapper d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">2</span>
                            </div>
                            <!--begin::Icon-->

                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">
                                    Information Personnel
                                </h3>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Line-->
                        <div class="stepper-line h-40px"></div>
                        <!--end::Line-->
                    </div>
                    <!--end::Step 2-->

                    <!--begin::Step 3-->
                    <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                        <!--begin::Wrapper-->
                        <div class="stepper-wrapper d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">3</span>
                            </div>
                            <!--begin::Icon-->

                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">
                                    Signature du contrat
                                </h3>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Line-->
                        <div class="stepper-line h-40px"></div>
                        <!--end::Line-->
                    </div>
                    <!--end::Step 3-->

                    <!--begin::Step 4-->
                    <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                        <!--begin::Wrapper-->
                        <div class="stepper-wrapper d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">4</span>
                            </div>
                            <!--begin::Icon-->

                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">
                                    Vérification d'identité
                                </h3>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Line-->
                        <div class="stepper-line h-40px"></div>
                        <!--end::Line-->
                    </div>
                    <!--end::Step 4-->
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Stepper-->
            <form action="{{ route('register.signate-init') }}" method="get" class="w-100 mx-auto">
                @csrf
                <x-base.underline title="Vos Informations Personnelles" size="3" sizeText="fs-1" color="bank"/>

                <div class="row">
                    <div class="col-3 mb-5">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Civilité</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span
                                    class="fs-4">{{ \App\Helper\CustomerInfoHelper::getCivility($personal['civility']) }}</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-9 mb-5">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Prénom</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span class="fs-4">{{ $personal['firstname'] }}</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Nom marital ou d'usage</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span class="fs-4">{{ $personal['middlename'] ?  : 'Aucun' }}</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Nom de naissance</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span class="fs-4">{{ $personal['firstname'] }}</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <x-base.alert
                    type="solid"
                    icon="circle-info"
                    color="primary"
                    title="Information importante"
                    content="Un justificatif de domicile sera demandé pour l'adresse déclarée" />

                <x-base.underline title="Votre Offre" size="3" sizeText="fs-1" color="bank"/>

                <div class="d-flex flex-column mb-5">
                    <div class="fs-2x fw-bolder">Pack {{ $package['name'] }}</div>
                    <div class="fs-6 fw-bold text-primary">Au prix de {{ eur($package['price']) }} par mois</div>
                </div>

                <div class="row mb-5">
                    <div class="col">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Durée de votre contrat</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span
                                    class="fs-4">Indéterminé</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Prise d'effet de votre contrat</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span class="fs-4">Immédiate</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-10">
                    <div class="col">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Délai de rétractation</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span
                                    class="fs-4">14 Jours calendaire à compter de la date de conclusion du contrat</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-10">
                    <div class="col">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Frais de changement d'offre</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span
                                    class="fs-4">5,90€ TTC, le 1er changement est offert</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <x-base.underline title="Votre Carte Bancaire" size="3" sizeText="fs-1" color="bank"/>

                <div class="d-flex flex-row border p-5 border-bank mb-10">
                    <div class="symbol symbol-100px symbol-2by3 me-5">
                        <img src="/storage/card/{{ $cart['type'] }}.png" alt=""/>
                    </div>
                    <div class="fs-2 fw-bold">
                        Carte Visa {{ Str::ucfirst($cart['type']) }} avec assurance & assistance incluse<br>
                        <span class="fw-normal text-muted fs-6">Fourniture d'une carte de débit (Carte de paiement Internationnal à débit {{ \App\Helper\CustomerCreditCard::getDebit($cart['debit']) }})</span>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Type de débit</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span class="fs-4">{{ \App\Helper\CustomerCreditCard::getDebit($cart['debit']) }}</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Paiement par carte / 30 jours</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span class="fs-4">{{ eur($limit_payment) }}</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column">
                            <span class="fs-6 text-grey-300 mb-3">Retrait par carte / 7 jours</span>
                            <div class="d-flex flex-row justify-content-between border-bottom border-2 border-info align-items-center">
                                <span class="fs-4">{{ eur($limit_retrait) }}</span>
                                <i class="fa-solid fa-check text-success fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="separator border-primary my-5"></div>

                <div class="mb-10">
                    <div class="d-flex flex-row justify-content-between">
                        <a href="{{ route('register.perso-pro') }}"
                           class="btn btn-lg btn-outline btn-outline-bank btn-disabled" disabled="true">Précédent</a>
                        <button type="submit" class="btn btn-lg btn-bank ">Suivant</button>
                    </div>
                </div>
            </form>

        </div>
        <!--end::Container-->
    </div>
    <!--begin::Heading-->
@endsection

@section("script")
    <script type="text/javascript">

    </script>
@endsection
