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
                    <div class="stepper-item mx-8 my-4 completed" data-kt-stepper-element="nav">
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
                    <div class="stepper-item mx-8 my-4 completed" data-kt-stepper-element="nav">
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

            <!--begin::Alert-->
            <div class="alert alert-dismissible bg-light-warning d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-20">
                <!--begin::Close-->
                <button type="button" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger" data-bs-dismiss="alert">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
                <!--end::Close-->

                <!--begin::Icon-->
                <i class="fa-solid fa-circle-user fa-5x text-danger mb-5"></i>
                <!--end::Icon-->

                <!--begin::Wrapper-->
                <div class="text-center">
                    <!--begin::Title-->
                    <h1 class="fw-bold mb-5">Vérification d'identité</h1>
                    <!--end::Title-->

                    <!--begin::Separator-->
                    <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                    <!--end::Separator-->

                    <!--begin::Content-->
                    <div class="mb-9 text-dark">
                        Vous allez devoir vérifié votre identité grâce à notre partenaire <a href="https://stripe.com">Stripe</a>.
                    </div>
                    <!--end::Content-->

                    <!--begin::Buttons-->
                    <div class="d-flex flex-center flex-wrap">
                        <x-base.button
                            id="verify"
                            class="btn-danger m-2"
                            text="Vérifier mon identité" />
                    </div>
                    <!--end::Buttons-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Alert-->

            <div class="separator border-primary my-5"></div>

            <div class="mb-20">
                <div class="d-flex flex-row justify-content-between">
                    <a href="{{ route('register.perso-pro') }}"
                       class="btn btn-lg btn-outline btn-outline-bank btn-disabled" disabled="true">Précédent</a>
                    <a href="{{ route('register.terminate') }}" class="btn btn-lg btn-success ">Terminer</a>
                </div>
            </div>

        </div>
        <!--end::Container-->
    </div>
    <!--begin::Heading-->
@endsection

@section("script")
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        let stripe = Stripe('{{ config('services.stripe.api_key') }}')

        let btn = document.querySelector('#verify')

        btn.addEventListener('click', e => {
            let verify = stripe.verifyIdentity('{{ $client_secret }}')
            console.log(verify)
        })
    </script>
@endsection
