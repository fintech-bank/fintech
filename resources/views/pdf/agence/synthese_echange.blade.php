@extends('pdf.layouts.app')

@section("content")
    <div class="fw-bolder fs-3 text-end mb-25">Récapitulatif de votre demande</div>
    <p>
        <strong>{{ \App\Helper\CustomerHelper::getName($customer) }},</strong><br>
        Vous trouverez ci-après les principales caractéristiques de votre demande d'ouverture de compte de particulier.
    </p>
    <div class="m-5 p-2" style="border: solid 1px #000000">
        <div class="fw-bolder fs-3 mb-10 text-primary">Vos informations personnelles</div>
        <p>
            <strong>{{ \App\Helper\CustomerHelper::getName($customer) }}</strong> né le <strong>{{ $customer->info->datebirth->format("d/m/Y") }}</strong>
            à <strong>{{ $customer->info->citybirth }} ({{ $customer->info->countrybirth }})</strong>
        </p>
        <div class="mb-10">
            <strong>Adresse Email:</strong> {{ $customer->user->email }}<br>
            <strong>Téléphone Fixe:</strong> {{ $customer->info->phone }}<br>
            <strong>Téléphone Mobile:</strong> {{ $customer->info->mobile }}<br>
        </div>
        <div class="mb-10">
            <strong>Domicile:</strong> {{ $customer->info->address }}, {{ $customer->info->addressbis ? $customer->info->addressbis.',' : '' }} {{ $customer->info->postal }} {{ $customer->info->city }} ({{ $customer->info->country }})
        </div>
        <div class="mb-10">
            <strong>Pays de résidence fiscal:</strong> {{ Str::upper($customer->info->country) }}<br>
            <strong>Votre adresse fiscale est identique à celle de votre domicile.</strong><br>
            @if($customer->info->country != 'fr' || $customer->info->country != 'FR' || $customer->info->country != 'France' || $customer->info->country != 'FRANCE')
                <strong>Vous avez une résidence fiscal à l'étranger</strong>
            @else
                <strong>Vous n'avez pas de résidence fiscal à l'étranger</strong>
            @endif
        </div>
        <div class="mb-10">
            <strong>Pays de Naissance:</strong> {{ Str::upper($customer->info->countrybirth) }}<br>
            <strong>Vous êtes:</strong> {{ $customer->situation->pro_category }}<br>
            <strong>Vous êtes:</strong> {{ $customer->situation->logement }}<br>
            <strong>Vous êtes:</strong> {{ $customer->situation->family_situation }}<br>
            <strong>Vous êtes:</strong> {{ $customer->situation->pro_profession }}
        </div>
        <div class="mb-10">
            <strong>Mon patrimoine est de:</strong> {{ eur($customer->income->patrimoine) }}<br>
            <strong>Mon revenue mensuel est de:</strong> {{ eur($customer->income->pro_incoming) }}<br>
        </div>
    </div>
    <div class="m-5 p-2" style="border: solid 1px #000000">
        <div class="fw-bolder fs-3 mb-10 text-primary">Votre Agence</div>
        <p>Pour retirer vos moyens de paiement, vous avez choisi l'agence:</p>
        <div class="fw-bold">
            {{ $customer->agency->name }}<br>
            {{ $customer->agency->address }}<br>
            {{ $customer->agency->postal }} {{ $customer->agency->city }}<br>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="m-5 p-2" style="border: solid 1px #000000">
        <div class="fw-bolder fs-3 mb-10 text-primary">Votre Offre</div>
        <p>Vous avez choisi l'offre: <strong>{{ $customer->package->name }}</strong></p>
        <p>Forfait à <strong class="fs-5">{{ eur($customer->package->price) }}</strong> / par mois avec:</p>
        <ul>
            <li>Une carte bancaire VISA {{ Str::ucfirst($data->card->support)}} à débit {{ \App\Helper\CustomerCreditCard::getDebit($data->card->debit) }}</li>
            <li>Un compte courant avec RIB Français</li>
        </ul>
    </div>
@endsection
