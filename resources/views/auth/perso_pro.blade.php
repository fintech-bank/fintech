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
            <form action="{{ route('register.perso-final') }}" method="get" class="w-100 mx-auto">
                @csrf
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

                <div class="separator border-primary my-5"></div>

                <div class="mb-10">
                    <div class="d-flex flex-row justify-content-between">
                        <a href="{{ route('register.perso-home') }}" class="btn btn-lg btn-outline btn-outline-bank btn-disabled" disabled="true">Précédent</a>
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
