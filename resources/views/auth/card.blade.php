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
                            <h1 class="fs-2hx fw-bold mb-5">Votre Carte Bancaire</h1>
                            <div class="text-gray-400 fw-semibold fs-5">Selectionner votre carte bancaire</div>
                        </div>
                        <!--end::Heading-->
                        <form id="formCard" action="{{ route('register.perso-home') }}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <input type="radio" class="btn-check" name="support" value="classic" checked="checked"  id="kt_radio_buttons_2_option_1" onchange="choiceCard()" />
                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="kt_radio_buttons_2_option_1">
                                        <!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
                                        <div class="symbol symbol-50px symbol-2by3 me-5">
                                            <img src="/storage/card/classic.png" alt=""/>
                                        </div>
                                        <!--end::Svg Icon-->

                                        <span class="d-block fw-semibold text-start">
                                        <span class="text-dark fw-bold d-block fs-3">Visa Classic</span>
                                    </span>
                                    </label>
                                    <!--end::Option-->
                                </div>
                                @if(session('package.name') != 'Cristal')
                                    <div class="col">
                                        <input type="radio" class="btn-check" name="support" value="premium"  id="kt_radio_buttons_2_option_2" onchange="choiceCard()" />
                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="kt_radio_buttons_2_option_2">
                                            <!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
                                            <div class="symbol symbol-50px symbol-2by3 me-5">
                                                <img src="/storage/card/premium.png" alt=""/>
                                            </div>
                                            <!--end::Svg Icon-->

                                            <span class="d-block fw-semibold text-start">
                                        <span class="text-dark fw-bold d-block fs-3">Visa Premium</span>
                                    </span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <div class="col">
                                        <input type="radio" class="btn-check" name="support" value="infinite" id="kt_radio_buttons_2_option_3" onchange="choiceCard()" />
                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="kt_radio_buttons_2_option_3">
                                            <!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
                                            <div class="symbol symbol-50px symbol-2by3 me-5">
                                                <img src="/storage/card/infinite.png" alt=""/>
                                            </div>
                                            <!--end::Svg Icon-->

                                            <span class="d-block fw-semibold text-start">
                                        <span class="text-dark fw-bold d-block fs-3">Visa Infinite</span>
                                    </span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                @endif
                            </div>
                            <div class="mb-10 d-none" id="typeDebit">
                                <label for="debit" class="form-label">Type de débit</label>
                                <select id="debit" class="form-select form-select-solid" data-control="select2" name="debit" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    <option value="immediate">Débit Immédiat</option>
                                    <option value="differed">Débit Différé</option>
                                </select>
                            </div>

                            <div class="d-flex flex-wrap">
                                <x-form.button
                                    text="Valider le choix de la carte bancaire" class="btn-bank w-100" />
                            </div>
                        </form>

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
    <script type="text/javascript">
        function choiceCard() {
            let type_debit = ""
            document.querySelectorAll('[name="support"]').forEach((input => {
                input.checked && (type_debit = input.value)
            }))

            if(type_debit === 'classic') {
                document.querySelector("#typeDebit").classList.add('d-none')
            } else {
                document.querySelector("#typeDebit").classList.remove('d-none')
            }
        }
    </script>
@endsection
