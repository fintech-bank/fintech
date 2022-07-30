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
            <form action="{{ route('register.perso-pro') }}" method="get" class="w-100 mx-auto">
                @csrf
                <div class="mb-10 d-flex flex-row justify-content-center">
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
                            label="Nom Marital" />
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
                <div class="row mb-10">
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

                <div class="separator border-primary my-5"></div>

                <div class="mb-10">
                    <div class="d-flex flex-row justify-content-between">
                        <a href="#" class="btn btn-lg btn-outline btn-outline-bank btn-disabled" disabled="true">Précédent</a>
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
        let countryBirthOptions = (item) => {
            if ( !item.id ) {
                return item.text;
            }

            let span = document.createElement('span');
            let imgUrl = item.element.getAttribute('data-kt-select2-country');
            let template = '';

            template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
            template += item.text;

            span.innerHTML = template;

            return $(span);
        }

        let cardsOptions = (item) => {
            if ( !item.id ) {
                return item.text;
            }

            let span = document.createElement('span');
            let imgUrl = item.element.getAttribute('data-card-img');
            let template = '';

            template += '<img src="' + imgUrl + '" class="rounded w-auto h-50px me-2" alt="image" />';
            template += item.text;

            span.innerHTML = template;

            return $(span);
        }

        let countryOptions = (item) => {
            if ( !item.id ) {
                return item.text;
            }

            let span = document.createElement('span');
            let imgUrl = item.element.getAttribute('data-kt-select2-country');
            let template = '';

            template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
            template += item.text;

            span.innerHTML = template;

            return $(span);
        }

        let citiesFromCountry = (select) => {
            console.log(select.value)
            let contentCities = document.querySelector('#divCities')
            $.ajax({
                url: '/api/geo/cities',
                method: 'post',
                data: {"country": select.value},
                success: data => {
                    console.log(data)
                    contentCities.innerHTML = data
                    $("#citybirth").select2()
                }
            })
        }

        let citiesFromPostal = (select) => {
            let contentCities = document.querySelector('#divCity')
            let block = new KTBlockUI(contentCities, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
            })
            block.block();

            $.ajax({
                url: '/api/geo/cities/'+select.value,
                success: data => {
                    block.release()
                    contentCities.innerHTML = data
                    $("#city").select2()
                }
            })
        }

        document.querySelectorAll('[name="postal"]').forEach(input => {
            input.addEventListener('keyup', e => {
                console.log(e.target.value.length)
                if(e.target.value.length === 5) {
                    citiesFromPostal(e.target)
                }
            })
        })

        $("#countrybirth").select2({
            templateSelection: countryBirthOptions,
            templateResult: countryBirthOptions
        })

        $("#country").select2({
            templateSelection: countryOptions,
            templateResult: countryOptions
        })

        $("#card_support").select2({
            templateSelection: cardsOptions,
            templateResult: cardsOptions
        })
    </script>
@endsection
