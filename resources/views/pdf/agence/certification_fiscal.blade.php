@extends('pdf.layouts.app')

@section("content")
    <div class="fw-bolder fs-3 text-end mb-25">Formulaire d'auto-certification de résidence fiscale<br>Personne physique</div>
    <div class="fs-2 fw-bolder">REGLEMENTATION FISCALE</div>
    <div class="m-5 p-2" style="border: solid 1px #000000">
        <span class="fs-italic fw-bold">Merci de lire les mentions ci-dessous avant de compléter ce formulaire :</span>
        <p>La réglementation fiscale exige que {{ config('app.name') }} recueille et déclare certaines informations sur la résidence
            fiscale du titulaire de comptes. Le terme « réglementation fiscale » fait référence aux réglementations qui permettent
            l’échange automatique d’informations et notamment la réglementation FATCA « Foreign Account Tax Compliance Act
            » et la norme OCDE d’échange automatique de renseignements relatifs aux comptes financiers dite CRS « Common
            Reporting Standard »</p>
        <p>Afin de permettre à {{ config('app.name') }} de se conformer à ses obligations, vous devez nous communiquer la
            résidence fiscale de la personne identifiée comme titulaire de comptes. Pour les comptes joints, chaque co-titulaire de
            compte doit compléter un formulaire individuel</p>
        <p><strong>Le présent formulaire n’est pas à utiliser si le titulaire de comptes n’est pas une personne physique.</strong>
            Merci de remplir dans ce cas le formulaire « Auto-certification de résidence fiscale – Personne Morale ».
        </p>
        <p><strong>Vous devez compléter l’ensemble des paragraphes</strong> applicables et fournir toute information complémentaire
            demandée permettant de justifier les déclarations faites dans ce formulaire.
        </p>
        <p><strong>Si un changement de résidence fiscale</strong> intervient ultérieurement, vous devrez nous adresser une nouvelle
            auto-certification dans un délai de 90 jours suivant ce changement de circonstance.</p>
        <p><strong>Pour les comptes joints</strong>, chaque co-titulaire de compte doit compléter un formulaire séparé.</p>
        <p>{{ config('app.name') }} n’est pas habilitée à remplir ce document en votre nom. Si vous avez des questions sur la façon
            de remplir ce formulaire ou sur les modalités de détermination de votre résidence fiscale, nous vous invitons à
            consulter votre conseiller fiscal ou les autorités administratives de votre lieu de résidence fiscale.</p>
        <p class="fw-bold fs-underline">Merci de ne rayer aucune clause de ce formulaire.</p>
    </div>
    <div class="page-break"></div>
    <div class="fs-2 fw-bolder">PROTECTION DES DONNEES PERSONNELLES</div>
    <div class="m-5 p-2" style="border: solid 1px #000000">
        <p>
            Les informations personnelles recueillies dans le cadre du présent formulaire sont obligatoires pour l’établissement et
            la qualification de votre statut fiscal conformément aux réglementations applicables. Elles pourront, de même que
            celles qui seront recueillies ultérieurement, être utilisées par {{ config('app.name') }} pour des besoins de gestion de la
            relation bancaire et notamment la sélection des risques, la prévention des incidents et fraudes, la connaissance du
            client et la lutte contre le blanchiment et le financement du terrorisme. Les durées de conservation relatives à ces
            finalités sont indiquées dans les Conditions Générales de votre convention de compte. Ces données personnelles
            pourront, de convention expresse, et en tant que de besoin au regard des finalités mentionnées ci-dessus, être
            communiquées aux personnes morales du Groupe {{ config('app.name') }}, ainsi qu’aux autorités compétentes de type
            autorités fiscales. Certains de ces destinataires peuvent être établis dans ou en dehors de l'Espace Économique
            Européen, y compris vers des pays dont les législations en matière de protection des données diffèrent de celles de
            l'Union Européenne. Ces transferts interviennent dans des conditions et sous des garanties propres à assurer la
            protection et la sécurité de vos données personnelles. Vous disposez d’un droit d’accès, de rectification et
            d’effacement*, de limitation du traitement*, ainsi qu’un droit à la portabilité* de vos données à caractère personnel.
            Vous pouvez également vous opposer, sous réserve de justifier d’un motif légitime, à ce que ces données fassent
            l’objet d’un traitement. Ces droits peuvent être exercés auprès du délégué à la protection des données personnelles*
            en vous adressant auprès du service ayant recueilli ces informations ou par email :
            {{ config('mail.from.address') }}. Vous avez le droit d’introduire une réclamation auprès de la Commission
            Nationale de l’Informatique et des Libertés (CNIL), autorité de contrôle en charge du respect des obligations en matière
            de données à caractère personnel.
            *Applicables à compter du 25 mai 2018.
        </p>
    </div>
    <div class="page-break"></div>
    <ol>
        <li class="fs-underline fw-bold mb-10">IDENTIFICATION DU TITULAIRE DE COMPTES</li>
        <table style="width: 100%; font-size: 10px" class="mb-20">
            <tbody>
                <tr>
                    <td colspan="2" class="fw-bold">A. Civilité</td>
                </tr>
                <tr>
                    <td style="width: 50%">Civilité</td>
                    <td style="width: 50%">{{ \App\Helper\CustomerInfoHelper::getCivility($customer->info->civility) }}</td>
                </tr>
                <tr>
                    <td style="width: 50%">Nom de naissance</td>
                    <td style="width: 50%">{{ Str::upper($customer->info->lastname) }}</td>
                </tr>
                <tr>
                    <td style="width: 50%">Nom d'usage</td>
                    <td style="width: 50%">{{ Str::upper($customer->info->middlename) }}</td>
                </tr>
                <tr>
                    <td style="width: 50%">Prénom</td>
                    <td style="width: 50%">{{ Str::upper($customer->info->firstname) }}</td>
                </tr>
                <tr>
                    <td style="width: 50%">Date de naissance</td>
                    <td style="width: 50%">{{ $customer->info->datebirth->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="width: 50%">Lieu de naissance</td>
                    <td style="width: 50%">{{ $customer->info->citybirth }}</td>
                </tr>
                <tr>
                    <td style="width: 50%">Pays de Naissance</td>
                    <td style="width: 50%">{{ $customer->info->countrybirth }}</td>
                </tr>
                <tr>
                    <td style="width: 50%">Êtes-vous citoyen des États-Unis*?</td>
                    <td style="width: 50%">
                        {{ $customer->info->countrybirth != 'US' || $customer->info->countrybirth != 'Etat-Unis' ? 'Non' : 'Oui' }}
                    </td>
                </tr>

            </tbody>
        </table>

        <table style="width: 100%; font-size: 10px" class="mb-20">
            <tbody>
                <tr>
                    <td colspan="2" class="fw-bold">B. Adresse Principal</td>
                </tr>
                <tr>
                    <td style="width: 50%">Adresse</td>
                    <td style="width: 50%">{{ $customer->info->address }}</td>
                </tr>
                <tr>
                    <td style="width: 50%">Complément</td>
                    <td style="width: 50%">{{ $customer->info->addressbis }}</td>
                </tr>
                <tr>
                    <td style="width: 50%">Code Postal / Ville</td>
                    <td style="width: 50%">{{ $customer->info->postal }} {{ $customer->info->city }}</td>
                </tr>
                <tr>
                    <td style="width: 50%">Pays</td>
                    <td style="width: 50%">{{ $customer->info->country }}</td>
                </tr>
            </tbody>
        </table>

        <li class="fs-underline fw-bold mb-10">PAYS DE RESIDENCE FISCALE</li>
        <ol class="mb-10">
            <li>Vous êtes résident fiscal de: {{ Str::upper($customer->info->country) }}</li>
            <li>Si vous êtes résident fiscal de France, le numéro de déclarant figurant sur la première page de votre déclaration ou de
                votre avis d’imposition correspond au Numéro d’Identification Fiscale (NIF). Dans le cas où vous seriez en mesure de nous
                le fournir, merci de l’indiquer ci-après ou de passez directement au B :</li>
            <li>Si vous êtes résident fiscal de France, le numéro de déclarant figurant sur la première page de votre déclaration ou de
                votre avis d’imposition correspond au Numéro d’Identification Fiscale (NIF). Dans le cas où vous seriez en mesure de nous
                le fournir, merci de l’indiquer ci-après ou de passez directement au B : NON</li>
            <li>Je certifie que je ne suis pas résident fiscal d’un autre pays que celui indiqué en A</li>
        </ol>
        <li class="fs-underline fw-bold mb-10">AUTRE(S) PAYS DE RESIDENCE FISCALE (à remplir uniquement si multi-résidence fiscale)</li>
        <p>Je certifie qu’en plus du pays mentionné ci-dessus, je suis résident fiscal dans le(s) pays suivant(s) et le(s) NIF(s)
            correspondant(s) à chaque pays est (sont) ci-dessous :</p>
        <table style="width: 100%;">
            <tbody>
            <tr>
                <td style="width: 33%;">Pays:____________________</td>
                <td style="width: 33%;">NIF:____________________</td>
                <td style="width: 33%;">NIF Indisponible:____________________</td>
            </tr>
            </tbody>

        </table>
        <li class="page-break"></li>
        <li class="fs-underline fw-bold mb-10">AUTORISATION ET ENGAGEMENTS</li>
        <div class="m-5 p-2" style="border: solid 1px #000000">
            <p>
                Le titulaire de comptes autorise {{ config('app.name') }} à fournir une copie de cette auto-certification, de tout formulaire
                de l’IRS (administration fiscale américaine) complété et remis par lui ainsi que toute autre information nécessaire pour
                l’établissement de son statut fiscal, à toute autorité fiscale compétente, à toute autorité habilitée à auditer ou contrôler
                {{ config('app.name') }} pour des raisons fiscales ainsi qu’à toute entité qui, au moment de la divulgation, appartient au
                Groupe {{ config('app.name') }}.
            </p>
            <p>
                Le titulaire de comptes accepte que toute information contenue dans cette auto-certification ainsi que toute information
                relative à son/ses compte(s), présent(s) et futur(s), y compris leur(s) solde(s) et les opérations créditrices, soit
                transmise à toute autorité à laquelle {{ config('app.name') }} est tenue de communiquer des informations d’ordre fiscal, à
                toutes autres parties selon ce que {{ config('app.name') }} peut estimer nécessaire pour se conformer aux «
                réglementations fiscales » FATCA et CRS applicables ou pour éviter toute violation potentielle de ces réglementations
                et à toute entité à laquelle {{ config('app.name') }} décide de confier tout ou partie de ses obligations de déclaration
                FATCA et CRS, y compris à toute société qui, au moment de la divulgation, appartient au Groupe {{ config('app.name') }}
            </p>
        </div>
        <li class="fs-underline fw-bold mb-10">DECLARATION ET SIGNATURE</li>
        <p>J’atteste que les informations figurant sur cette auto-certification sont exactes et complètes. Je m’engage à informer
            {{ config('app.name') }} de tout changement dans un délai de 90 jours et à remplir une nouvelle auto-certification dans le
            même délai si la présente se révélait incorrecte.</p>
        <p>
            Je certifie que je suis le titulaire (ou la personne autorisée à signer) de tous les comptes pour lesquels ce formulaire est
            établi.
        </p>
        <p>Je certifie que la personne nommée en section 1.A de ce formulaire*:</p>
        @if($customer->info->countrybirth != 'US' || $customer->info->countrybirth != 'Etat-Unis')
            <p><strong>N’est pas une « Personne US déterminée (Specified US person)</strong></p>
        @else
            <p>
                <strong>Est une « Personne US déterminée (Specified US person) »</strong><br>
                Si vous êtes une « Personne US déterminée (Specified US person) » au sens de la définition de l’IRS
                (citoyenneté des Etats-Unis, résidence fiscale aux Etats-Unis, détention d’une carte verte en cours de
                validité), vous devez également compléter et nous adresser le formulaire W-9 de l’IRS.
            </p>
        @endif
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
    </ol>
@endsection
