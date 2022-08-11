@extends('pdf.layouts.app')

@section("content")
    <div class="text-center fs-3 fs-underline">CONVENTION DE COMPTE</div>
    <div class="text-center fs-3">CONDITIONS PARTICULIERES</div>
    <div class="mt-10 mb-10 text-center" style="border: solid 2px #000000; background-color: #a4a4a4">IDENTIFICATION DU
        TITULAIRE
    </div>

    <table style="width: 100%;">
        <tbody>
        <tr>
            <td style="width: 50%;">
                <table style="width: 100%;">
                    <tbody>
                    <tr>
                        <td style="width: 50%;">{{ \App\Helper\CustomerInfoHelper::getCivility($customer->info->civility) }}</td>
                        <td style="width: 50%;">{{ $customer->info->middlename ?  : $customer->info->lastname }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Nom de naissance</td>
                        <td style="width: 50%;">{{ $customer->info->lastname }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Prénom</td>
                        <td style="width: 50%;">{{ $customer->info->firstname }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Situation familliale</td>
                        <td style="width: 50%;">{{ $customer->situation->family_situation }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Téléphone Fixe</td>
                        <td style="width: 50%;">{{ $customer->info->phone }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Téléphone Portable</td>
                        <td style="width: 50%;">{{ $customer->info->mobile }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Adresse Mail</td>
                        <td style="width: 50%;">{{ $customer->user->email }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 50%;">
                <table style="width: 100%;">
                    <tbody>
                    <tr>
                        <td style="width: 50%;">Date de Naissance</td>
                        <td style="width: 50%;">{{ $customer->info->datebirth->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Commune de Naissance</td>
                        <td style="width: 50%;">{{ $customer->info->citybirth }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Pays de Naissance</td>
                        <td style="width: 50%;">{{ $customer->info->countrybirth }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="mt-10 mb-10 text-center" style="border: solid 2px #000000; background-color: #a4a4a4">ADRESSE</div>
    <ol>
        <li class="fs-underline">Adresse Principal</li>
        <p>
            {{ $customer->info->address }}<br>
            {{ $customer->info->addressbis ? $customer->info->addressbis.'<br>':'' }}
            {{ $customer->info->postal }} {{ $customer->info->city }}<br>
            {{ $customer->info->country }}
        </p>
    </ol>
    <div class="fs-2 fw-bold">Protection des données personnelles</div>
    <p>
        {{ config('app.name') }}, établissement bancaire et courtier en assurances, est amenée à traiter en qualité de responsable de
        traitement, vos données personnelles notamment pour les besoins de la gestion des contrats et services, de la relation
        commerciale, et afin de répondre à ses obligations légales et réglementaires. Vous pouvez retrouver le détail des
        traitements réalisés, en ce compris les données traitées, les finalités, les bases légales applicables, les destinataires, les
        durées de conservation, et les informations relatives aux transferts hors Espace économique européen, sur l’espace
        internet particuliers dans la rubrique – nos engagements/informations réglementaires, ou sur demande de votre part
        dans votre agence. Cette information vous est également communiquée à l’ouverture de votre compte, et à l’occasion
        des modifications dont elle peut faire l’objet. Vous disposez d’un droit d’accès et de rectification, d’effacement, de
        limitation du traitement, ainsi que d’un droit à la portabilité de vos données. Vous pouvez également vous opposer pour
        des raisons tenant à votre situation particulière, à ce que vos données à caractère personnel fassent l’objet d’un
        traitement, ou encore définir des directives générales ou spécifiques sur le sort de vos données personnelles en cas de
        décès. Vous pouvez aussi, à tout moment et sans frais, sans avoir à motiver votre demande, vous opposer à ce que vos
        données soient utilisées à des fins de prospection commerciale. Vous pouvez exercer vos droits, ainsi que contacter le
        délégué à la protection des données personnelles en vous adressant:
    </p>
    <ul>
        <li>Par courrier électronique à l’adresse suivante : {{ config('mail.from.address') }};</li>
        <li>Sur votre Espace client;</li>
        <li>
            À l’adresse postale suivante :<br>
            {{ config('app.name') }} - Service Protection des données personnelles<br>
            {{ $customer->agency->address }}<br>
            {{ $customer->agency->postal }} {{ $customer->agency->city }}
        </li>
        <li>Auprès de l’agence où est ouvert votre compte.</li>
    </ul>
    <p>
        Enfin, vous avez le droit d’introduire une réclamation auprès de la Commission Nationale de l’Informatique et des Libertés (CNIL),
        autorité de contrôle en France en charge du respect des obligations en matière de données à caractère personnel.
    </p>
    <div class="page-break"></div>
    <div class="mt-10 mb-10 text-center" style="border: solid 2px #000000; background-color: #a4a4a4">COMPTES</div>
    <p class="fs-underline fs-3">COMPTE DE PARTICULIER</p>
    <p class="fs-underline fs-3">COMPTE DE PARTICULIER INDIVIDUEL</p>
    <table style="width: 100%;" class="table bordered gy-7 gs-7">
        <thead>
            <tr>
                <td>Code Banque</td>
                <td>Code Guichet</td>
                <td>Numéro de Compte</td>
                <td>Clé RIB</td>
                <td>Devise</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $customer->agency->code_banque }}</td>
                <td>{{ $customer->agency->code_agence }}</td>
                <td>{{ $data->wallet->number_account }}</td>
                <td>{{ $data->wallet->rib_key }}</td>
                <td>EUR</td>
            </tr>
        </tbody>
    </table>
    <p>
        <span class="fs-underline">TARIFICATION:</span> L’ouverture d’un compte est gratuite. En revanche, outre la facturation des prestations et services
        rendus dans le cadre de la Convention d’ouverture de compte, la gestion du compte donnera lieu, le cas échéant, à la
        perception de frais de tenue de compte dont le montant et les conditions sont indiqués dans le document « Conditions
        appliquées aux opérations bancaires – particuliers »(1), remis avec le dossier d’ouverture de compte et tenu à la
        disposition de la clientèle dans les agences SOCIETE GENERALE et sur le site Internet
        {{ config('app.url') }}.
    </p>
    <div class="page-break"></div>
    <div class="mt-10 mb-10 text-center" style="border: solid 2px #000000; background-color: #a4a4a4">ADHESION A LA CONVENTION DE COMPTE</div>
    <p>La convention de compte (ci-après « la Convention ») se compose :</p>
    <ul>
        <li>Du dossier d’ouverture de compte</li>
        <li>Des conditions générales de compte de particuliers</li>
        <li>Des conditions particulières</li>
        <li>De la brochure tarifaire (document intitulé « Tarifs – conditions appliquées aux opérations bancaires ») ;</li>
        <li>Et de tous les éventuels courriers ou courriels émanant de SOCIETE GENERALE</li>
    </ul>
    <p>
        L’ouverture du compte dans les livres de SOCIETE GENERALE est réputée effective après vérification du dossier d’ouverture de
        compte, dûment rempli et signé par le demandeur et accompagné des pièces requises par SOCIETE GENERALE et lorsque les fonds
        requis pour cette ouverture sont crédités sur le compte ouvert dans les livres de SOCIETE GENERALE.
    </p>
    <p>
        SOCIETE GENERALE demeure libre, à tout moment, d'accepter ou de refuser le dossier d’ouverture de compte tant que la SOCIETE
        GENERALE n’a pas adressé la lettre d’agrément au client.
    </p>
    <p class="fs-underline">En signant les présentes Conditions Particulières,</p>
    <ul>
        <li>
            Je déclare avoir pris connaissance des Conditions Générales de fonctionnement de la banque à distance - Conditions
            appliquées aux opérations bancaires des particuliers (1) qui m’ont été adressées en complément de ces Conditions
            Particulières, et en accepte tous les termes sans réserve ;
        </li>
        <li>
            Je déclare être majeur capable et m'engager en nom propre (à l'exception d'une représentation légale d'un majeur protégé)
        </li>
        <li>
            Je demande la souscription de la banque à distance telle qu’exposée ci-dessus en ayant connaissance du fait que cette
            souscription est soumise à l’agrément de {{ config('app.name') }} ;
        </li>
        <li>
            Je suis informé(e):
            <ul>
                <li>
                    que la signature de la convention de compte doit être réalisée dans les 60 jours suivant la validation du
                    formulaire d’ouverture de compte en ligne, avec l’ensemble des pièces justificatives, au plus tard 60 jours
                    calendaires suivant la validation de mon formulaire de demande d’ouverture de compte en ligne. Au-delà, ma
                    demande ne pourra plus être prise en compte et je devrais faire une nouvelle demande
                </li>
                <li>
                    qu’en cas d’agrément par {{ config('app.name') }}, celui-ci me sera notifié par courrier (« Lettre d’agrément »). Je
                    disposerai de 14 jours calendaires (si ce délai expire un samedi, un dimanche ou un jour férié ou chômé, il sera
                    prorogé jusqu’au premier jour ouvrable suivant) à compter de l’agrément de la banque (cachet de la Poste
                    faisant foi) pour me rétracter au moyen du formulaire de rétractation envoyé par lettre recommandée avec
                    accusé de réception. Passé ce délai de rétractation, la Convention pourra être résiliée dans les conditions
                    prévues aux conditions générales de la convention de compte.
                </li>
            </ul>
        </li>
    </ul>
    <div class="page-break"></div>
    <div class="text-center fs-3 fs-underline">SOUSCRIPTION DE PRODUITS ET SERVICES: Carte de Paiement</div>
    <div class="text-center fs-3">CONDITIONS PARTICULIERES</div>
    <div class="mt-10 mb-10 text-center" style="border: solid 2px #000000; background-color: #a4a4a4">Carte de Paiement</div>
    <div class="mb-10">
        <div class="fs-2 fs-underline">NOM DE LA CARTE CHOISIE</div>
        <p>Carte Visa {{ $data->card->support }} à débit {{ \App\Helper\CustomerCreditCard::getDebit($data->card->debit) }} de {{ \App\Helper\CustomerHelper::getName($customer) }}</p>
    </div>
    <div class="mb-10">
        <div class="fs-2 fs-underline">TITULAIRE DE LA CARTE</div>
        {{ \App\Helper\CustomerInfoHelper::getCivility($customer->info->civility) }} {{ $customer->info->lastname }}
    </div>
    <div class="mb-10">
        <div class="fs-2 fs-underline">Carte Visa {{ Str::ucfirst($data->card->support) }}</div>
        <p>Carte de débit à autorisation systématique - CB VISA de {{ Str::upper(\App\Helper\CustomerHelper::getName($customer)) }}</p>
        <table class="table table-bordered table-sm gs-5 gy-5">
            <tbody>
                <tr>
                    <td>Type de débit:</td>
                    <td>{{ \App\Helper\CustomerCreditCard::getDebit($data->card->debit) }}</td>
                </tr>
                <tr>
                    <td>Capacité de paiement:</td>
                    <td>{{ eur($data->card->limit_payment) }} / mois</td>
                </tr>
                <tr>
                    <td> Capacité de retrait global France et étranger:</td>
                    <td>{{ eur($data->card->limit_retrait) }} / 7 jours</td>
                </tr>
                <tr>
                    <td> Adresse envoi correspondance :</td>
                    <td>{!! \App\Helper\CustomerInfoHelper::getAddress($customer->info) !!}</td>
                </tr>
                <tr>
                    <td> Compte Débité:</td>
                    <td>{{ \App\Helper\CustomerWalletHelper::getNameAccount($data->wallet) }}</td>
                </tr>
            </tbody>
        </table>
        <p>
            J'autorise SOCIETE GENERALE à débiter du compte visé ci-dessus le montant de la cotisation annuelle ainsi que les
            sommes correspondant aux utilisations de la carte conformément aux dispositions des Conditions Générales de
            fonctionnement des cartes.
        </p>
    </div>
    <div class="m-5 p-5" style="border: solid 1px #000000">
        <table style="width: 100%;">
            <tbody>
            <tr>
                <td style="width: 60%;">
                    Nom et Prénom du signataire: {{ \App\Helper\CustomerHelper::getName($customer) }}<br>
                    Fait à: {{ $customer->agency->city }}<br>
                    Le: {{ now()->format('d/m/Y') }}
                </td>
                <td style="width: 20%; text-align: center">
                    @if(isset($document) && $document->signed_by_client == true)
                        Signé éléctroniquement le {{ now()->format('d/m/Y') }}.<br>@if($customer->info->type == 'part') {{ $customer->info->civility.'. '. $customer->info->lastname.' '.$customer->info->firstname }} @else {{ $customer->info->company }} @endif
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
