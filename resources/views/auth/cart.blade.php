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
                            <h1 class="fs-2hx fw-bold mb-5">Votre Offre</h1>
                            <div class="text-gray-400 fw-semibold fs-5">Voici les produits que vous avez choisis. Validez votre offre pour continuer votre ouverture de compte.</div>
                        </div>
                        <!--end::Heading-->
                        <div class="w-700px d-flex flex-column mx-auto">
                            <div class="d-flex flex-row justify-content-between mb-15">
                                <span class="fs-3 fw-bolder">Compte Bancaire (Pack {{ session()->get('package.name') }})</span>
                                <span class="fs-3">{{ eur(session()->get('package.price')) }} / mois</span>
                            </div>
                            <a href="{{ route('register.card') }}" class="btn btn-bank btn-lg rounded">Valider mon offre</a>
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
