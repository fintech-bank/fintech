@extends('pdf.layouts.app')

@section("content")
    <div class="fs-4 fw-bolder text-center mb-10">
        CONTRAT CARTE CB-VISA {{ Str::upper($data['card']->support) }}
        @if($data['card']->support == "classic")
            A AUTORISATION SYSTEMATIQUE
        @else
            A AUTORISATION QUASI-SYSTEMATIQUE
        @endif
    </div>
    <div class="fs-2 fw-bold text-center mb-10">Fourniture d'une carte de {{ \App\Helper\CustomerCreditCard::isDiffered($data['card']->debit) == false ? 'Crédit' : 'Débit' }} (Carte de paiement internationnale à débit {{ \App\Helper\CustomerCreditCard::getDebit($data['card']->debit) }})</div>
    <div class="fw-bolder">TITULAIRE DU COMPTE ET DE LA CARTE: {{ \App\Helper\CustomerHelper::getName($customer) }}</div>
    @if($customer->info->type == 'part')
        <div>Date de naissance: {{ $customer->info->datebirth->format("d/m/Y") }}</div>
    @endif
    <div>Adresse: {{ $customer->info->address }} {{ $customer->info->addressbis != null ? '- '.$customer->info->addressbis : '-' }} {{ $customer->info->postal }} {{ $customer->info->city }} - {{ $customer->info->country }}</div>
    <div class="separator border-2 border-dark my-10"></div>
    <div class="fs-3 fw-bolder text-center">CONDITIONS PARTICULIERES</div>
    <table class="table border border-2 border-gray-800 mb-10">
        <tbody>
        <tr class="border-bottom border-gray-800 h-50px">
            <td class="w-50">Référence du contrat: {{ $document->reference }}</td>
            <td class="w-50">Numéro de compte support de la carte: {{ $data['card']->wallet->number_account }}</td>
        </tr>
        <tr class="border-bottom border-gray-800 h-50px">
            <td class="w-50">Type de carte: {{ \App\Helper\CustomerCreditCard::getType($data['card']->type) }}</td>
            <td class="w-50">Type de débit: {{ \App\Helper\CustomerCreditCard::getDebit($data['card']->debit) }}</td>
        </tr>
        <tr class="border-bottom border-gray-800 h-50px">
            <td rowspan="2" class="w-50">Service CARTEGO souscrit: NON<br><br>Standard</td>
            <td class="w-50">Catégorie de la carte selon le règlement (UE) 2015/751 du 29/05/2015:<br>{{ \App\Helper\CustomerCreditCard::isDiffered($data['card']->debit) == false ? 'Crédit' : 'Débit' }}</td>
        </tr>
        <tr class="border-bottom border-gray-800 h-50px">
            <td class="w-50">Carte doté de la fonction sans contact: {{ \App\Helper\CustomerCreditCard::getContact($data['card']->payment_contact) }}</td>
        </tr>
        </tbody>
    </table>
    <p class="mb-5">
        Le titulaire de la carte et/ou du compte doit déclarer par téléphone dans les meilleurs délais, la perte, le vol de la carte ou
        l’utilisation frauduleuse des données de la carte au centre d'opposition de la Banque : 01.77.86.24.24 (prix d'un appel local).
    </p>
    <div class="fs-3 fw-bolder text-center">MODALITES D'UTILISATION</div>
    <p>Les plafonds d'autorisation de votre carte sont :</p>
    <table class="table border border-2 border-gray-800 mb-10">
        <tbody>
        <tr class="border-bottom border-gray-800 h-50px">
            <td class="w-50">
                <strong>Retraits:</strong> {{ eur($data['card']->limit_retrait) }} / 7 jours glissant
            </td>
            <td class="w-50">
                <strong>Paiement:</strong> {{ eur($data['card']->limit_payment) }} / 30 jours glissant
            </td>
        </tr>
        </tbody>
    </table>
    <p>Les plafonds à l'étranger sont compris dans les plafonds France. Pour modifier ces plafonds, merci de consulter votre agence.</p>
    <p>
        Visualisation du code confidentiel sur l’espace de banque à distance :<br>
        Vous choisissez de recevoir le code confidentiel de votre carte par courrier lors de la souscription de la carte ou en cas de
        refabrication de la carte suite à une mise en opposition. Par exception, si vous faites opposition sur votre espace de banque à
        distance, via votre application mobile de votre Banque, le code confidentiel de votre nouvelle carte sera mis à disposition sur
        cet espace dans votre application bancaire mobile.
    </p>
    <p>
        Possibilité de bloquer/débloquer les paiements à distance :<br>
        Lors de la présente souscription, l’option « paiements à distance » de votre carte est activée. Vous reconnaissez avoir été
        informé de la possibilité d’activer et de désactiver la fonction de paiement à distance (internet, téléphone et courrier) de la
        carte souscrite, depuis votre espace de banque à distance si vous êtes abonné aux services de banque à distance de votre
        Banque, ou en adressant une demande à votre agence.
    </p>
    <p>Les comptes accessibles aux GAB sont, à la date de signature :</p>
    <p class="border border-gray-800">{{ $data['card']->wallet->number_account }} {{ \App\Helper\CustomerHelper::getName($customer) }}</p>
    <p>Pour votre sécurité, votre nouvelle carte est fabriquée et transportée inactive. Pour l'activer, vous devez effectuer un retrait sur
        un distributeur automatique de billets ou un paiement chez un commerçant, validé par votre code confidentiel*.</p>
    <p>Dans la mesure du possible et si vous y avez accès, l'activation de cotre carte peut ce faire par l'intermédiaire de votre espace client en tapant votre code SECURPASS.</p>
    <p>Fait le {{ now()->format('d/m/Y') }}</p>
    <table class="table table-rounded border gy-7 gs-7 m-10">
        <thead>
        <tr class="fw-bolder fs-5 text-gray-800 border-bottom border-gray-200 text-center">
            <th>Le titulaire</th>
            <th>La banque {{ $agence->name }}</th>
        </tr>
        </thead>
        <tbody>
        <tr class="h-50px">
            <td class="text-center fs-8">
                Signé éléctroniquement le {{ now()->format('d/m/Y') }}.<br>{{ \App\Helper\CustomerHelper::getName($customer) }}
            </td>
            <td class="text-center fs-8">
                Signé éléctroniquement le {{ now()->format('d/m/Y') }} par la banque
            </td>
        </tr>
        </tbody>
    </table>
@endsection
