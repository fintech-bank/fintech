@extends('pdf.layouts.app')

@section("content")
    <div class="fs-4 fw-bolder text-center mb-10">CONVENTION DE RELATION FORFAIT {{ Str::upper($customer->package->name) }}</div>
    <div class="fs-2 fw-bold text-center mb-3">CONDITIONS CONTRACTUELLES</div>

    <p>
        La présente convention (la « Convention ») comprend les conditions contractuelles, les conditions générales relatives à la convention
        de relation FORFAIT {{ Str::upper($customer->package->name) }}, les éventuelles annexes et conventions spécifiques. A celle-ci s’ajoutent les conditions
        tarifaires de la Banque en vigueur.
    </p>
    <div class="separator border-2 border-dark my-10"></div>
    <div class="fw-bold mb-5">TYPE: Souscription</div>
    <table class="table border border-2 border-gray-800 mb-10">
        <thead>
        <tr class="border-bottom border-gray-800">
            <th class="fw-bolder" colspan="2">FORFAIT {{ Str::upper($customer->package->name) }}</th>
        </tr>
        </thead>
        <tbody>
        <tr class="border-bottom border-gray-800">
            <td class="w-50">Contrat N° {{ $document->reference }}</td>
            <td class="w-50">Date de prise d'effet: {{ now()->format('d/m/Y') }}</td>
        </tr>
        </tbody>
    </table>
    <table class="table border border-2 border-gray-800 mb-10 w-100">
        <thead>
        <tr class="border-bottom border-gray-800">
            <th class="fw-bolder" colspan="2">Souscrit entre la banque {{ $agence->name }}, identifié ci-dessus et le titulaire ci-dessous désigné:</th>
        </tr>
        </thead>
        <tbody>
        <tr class="border-bottom border-gray-800">
            <td class="" colspan="2">N° Client: {{ $customer->user->identifiant }}</td>
        </tr>
        <tr class="border-bottom border-gray-800">
            <td class="" colspan="2">
                @if($customer->info->type == 'part')
                    {{ $customer->info->civility }}. {{ $customer->info->lastname }} {{ $customer->info->firstname }}
                @else
                    {{ $customer->info->company }}<br>
                @endif
                {{ $customer->info->address }}<br>
                @isset($customer->info->addressbis)
                    {{ $customer->info->addressbis }}<br>
                @endisset
                {{ $customer->info->postal }} {{ $customer->info->city }}<br>
                {{ $customer->info->country }}
            </td>
        </tr>
        </tbody>
    </table>
    <table class="table border border-2 border-gray-800 mb-10">
        <thead>
        <tr class="border-bottom border-gray-800">
            <th class="fw-bolder" colspan="2">Composante de la CONVENTION</th>
        </tr>
        </thead>
        <tbody>
        <tr class="border-bottom border-gray-800 h-50px">
            <td class="">
                <u class="fw-bold fs-4 mb-2">FONCTIONNEMENT</u>
                <p>
                    @if($customer->package->cheque == 1)
                        - CHEQUIER<br>
                        <br>
                        Mise à disposition à l’agence<br>
                        ou Envoi en courrier simple (sur demande expresse du client qui reconnaît avoir été averti des risques qu’il encourait en acceptant  de recevoir ses chéquiers par lettres simples (et notamment en cas de vol).<br>
                        ou Envoi en recommandé.<br>
                        <br>
                        En cas de défaut de provision, les titulaires choisissent d’être informés :<br>
                        - par lettre simple<br>
                        - OU par Téléphone<br>
                        - OU par mise à disposition de la lettre dans l’espace « e-Documents » du service de banque à distance.<br>
                    @endif
                    - CARTE BANCAIRE<br>
                    <br>
                    Si la Banque a convenance à délivrer une carte de paiement et/ou de retrait, cette délivrance fait l’objet d’une demande du titulaire du
                    compte donnant lieu à la signature d’une convention spécifique fixant les modalités de fonctionnement et d’utilisation de ladite carte.
                </p>
                <u class="fw-bold fs-4 mb-2">INFORMATION SUR VOTRE COMPTE</u>
                <ul class="list-unstyled">
                    <li>- COMPTE @if($customer->info->type == 'part') {{ $customer->info->civility.'. '. $customer->info->lastname.' '.$customer->info->firstname }} @else {{ $customer->info->company }} @endif - N°{{ $customer->wallets()->first()->number_account }} EXTRAIT MENSUEL</li>
                    <li>- AUTORISATION DE DECOUVERT: Néant</li>
                </ul>
                <u class="fw-bold fs-4 mb-2">VOTRE COMPTE A DISTANCE</u>
                <ul class="list-unstyled">
                    <li>
                        - Accès au service de compte en ligne FIDEX, au caractéristiques et aux conditions précisées ci-dessous:<br>
                        <ul class="list-unstyled">
                            <li>&nbsp;</li>
                            <li>Type de service: FIDEX Particulier</li>
                            <li><i>Selon tarif en vigueur</i></li>
                        </ul>
                    </li>
                </ul>
                <u class="fw-bold fs-4 mb-2">SECURPLUS</u>
                <p>
                    Offre d’assurance de groupe perte ou vol de moyens de paiement, papiers, clés ainsi qu’en cas d’usurpation d’identité, du bris
                    accidentel ou du vol du téléphone mobile, SÉCURPLUS, souscrit par {{ $agence->name }} auprès de
                    {{ config('app.name') }} PRÉVOYANCE
                </p>
                <ul class="list-unstyled">
                    <li>CONTRAT N°{{ $document->reference }} pour l'adhérant @if($customer->info->type == 'part') {{ $customer->info->civility.'. '. $customer->info->lastname.' '.$customer->info->firstname }} @else {{ $customer->info->company }} @endif</li>
                </ul>
                <p class="mt-10">
                    <i>La souscription à la présente convention entraîne, sans autre formalité et de plein droit, la résiliation de toute convention
                        précédemment conclue par le client et relative à un produit et/ou service inclus par la présente convention, ce pour éviter une
                        quelconque double facturation.</i>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
    <p>
        Préalablement à la signature de la Convention, le Client reconnaît avoir pris connaissance et compris l’intégralité des conditions
        régissant la Convention comprenant les conditions contractuelles/particulières, les conditions générales portant le n° CNV06700
        CG201909, la notice d’information sur le traitement des données à caractère personnel et les conditions tarifaires ; la Banque ayant
        mis à sa disposition les moyens suivants :
    </p>
    <ul>
        <li>consultation d’un exemplaire papier ou sur écran en agence</li>
        <li>consultation sur support durable mis en ligne sur le site internet de la Banque : finbank.bzhm.tk</li>
    </ul>
    <p>
        En cas de vente à distance ou de démarchage, et par dérogation aux conditions contractuelles/particulières ci-avant, en complément
        des moyens d’informations en face à face, le Client accepte de recevoir la communication des conditions générales par les moyens
        suivants :
    </p>
    <ul>
        <li> envoi postal du document sous forme papier,</li>
        <li>téléchargement du document par envoi électronique.</li>
    </ul>
    <p>
        Le Client déclare avoir pris connaissance, lu, compris et accepter sans réserves, modification ou correction, l’intégralité des conditions
        régissant la Convention ainsi que les conditions tarifaires de la Banque en vigueur à ce jour.
    </p>
    <p>
        A cet effet, le Client reconnaît avoir obtenu indépendamment de la communication des conditions générales portant le n° CNV06700
        CG201909, sur support durable comme visé ci-dessus, la communication de ces conditions générales grâce aux moyens suivants :<br>
        - envoi du document par la Banque par courriel à son adresse mail déclarée,<br>
        - remise d’un exemplaire papier en agence lors de la signature de la Convention,<br>
        - envoi postal du document sous forme papier,<br>
        - téléchargement du document par envoi électronique<br>
    </p>
    <p class="fw-bolder">
        Pour des raisons de praticité, de constitution de preuve et de consultations ultérieures, le Client mandate la Banque pour
        obtenir conservation des conditions générales portant le n° CNV06700 CG201909 (numérotées de 1 à 2) auxquelles il déclare
        adhérer.<br>
        La Banque accepte la mission et confie pour le compte du Client, la garde des conditions générales susvisées à un Officier
        Ministériel, garant de la conservation et de l’intégrité de l’acte.<br>
        A tout moment, sur simple demande du Client à l’adresse suivante, une copie certifiée conforme des conditions générales lui
        sera adressée gratuitement par l’étude d’Huissier de Justice, SCP LRGPV, domiciliée 12, rue Camille à OULLINS (69 600),
        téléphone : 04.72.39.77.00, télécopie : 04.72.39.17.66, e-mail : franck.vacher@huissier-justice.fr
    </p>
    <p class="fw-bolder">
        Le Client peut également obtenir communication de ce document à tout moment sur simple demande formulée par écrit au
        service Relations Clients de la Banque, 22 Rue Maryse Bastié - CS 26858 - 85100 Les Sables d'Olonne ou le consulter
        sur le site internet de la Banque (finbank.bzhm.tk "rubrique Tarifs & réglementation").
    </p>
    <table class="table border border-2 border-gray-800 mb-10 w-100">
        <thead>
        <tr class="border-bottom border-gray-800">
            <th class="fw-bolder p-5">COTISATION</th>
        </tr>
        </thead>
        <tbody>
        <tr class="border-bottom border-gray-800 w-100">
            <td class="px-5 w-50">
                Le titulaire autorise le prélèvement mensuel de la première cotisation de {{ eur($customer->package->price) }} et des cotisations ultérieures sur son compte N°
                {{ $customer->wallets()->first()->number_account }}<br>
                Périodicité des cotisations ultérieures : MENSUELLE
            </td>
        </tr>
        </tbody>
    </table>
    <p>Fait le {{ now()->format('d/m/Y') }}</p>
    <table class="table table-rounded border gy-7 gs-7 m-10 w-100">
        <thead>
        <tr class="fw-bolder fs-5 text-gray-800 border-bottom border-gray-200 text-center">
            <th>Le titulaire</th>
            <th>La banque {{ $agence->name }}</th>
        </tr>
        </thead>
        <tbody>
        <tr class="h-50px">
            <td class="text-center fs-8">
                Signé éléctroniquement le {{ now()->format('d/m/Y') }}.<br>@if($customer->info->type == 'part') {{ $customer->info->civility.'. '. $customer->info->lastname.' '.$customer->info->firstname }} @else {{ $customer->info->company }} @endif
            </td>
            <td class="text-center fs-8">
                Signé éléctroniquement le {{ now()->format('d/m/Y') }} par la banque
            </td>
        </tr>
        </tbody>
    </table>
@endsection
