@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Maintenant, c'est simple de changer de banque avec la mobilité bancaire</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($customer) }}</span>
            <p class="fw-bolder">Vous venez d'ouvrir un compte {{ config('app.name') }}, bienvenue.</p>
            <p>Pour commencer, votre espace client est maintenant accessible avec votre identifiant et votre adresse mail:</p>
            <ul>
                <li><strong>Identifiant:</strong> {{ $customer->user->identifiant }}</li>
                <li><strong>Email:</strong> {{ $customer->user->email }}</li>
                <li><strong>Code SecurPass temporaire:</strong> {{ base64_decode($customer->auth_code) }}</li>
            </ul>
            <p>Si vous souhaitez changer de banque et faire de {{ config('app.name') }} votre banque principale, <strong>vous pouvez utiliser notre service Transbank</strong>
                Ce service est accessible par l'intermédiaire de votre espace client <strong>Rubrique "Mon Profil > Transbank"</strong>.</p>
            <p>
                <strong>Une fois votre inscription au service effectuer, on vous demandera de signer un mandat de mobilité. Et on s'occupe de tout</strong> pour que vos prélèvements,
                et virement récurrents qui était sur votre ancien compte arrivent sur votre compte {{ config('app.name') }}.
            </p>
            <p><strong>De plus</strong>, vous trouverez en pièces jointes des documents à conserver:</p>
            <ul>
                <li>Votre contrat</li>
                <li>Un guide sur la mobilité bancaire avec TransBank</li>
            </ul>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

