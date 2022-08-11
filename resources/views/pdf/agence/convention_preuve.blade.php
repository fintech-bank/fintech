@extends('pdf.layouts.app')

@section("content")
    <div class="fw-bolder fs-4 text-end mb-25">CONVENTION DE PREUVE</div>
    <p>La présente convention de preuve complète les dispositions du contrat de Banque à Distance que le signataire reconnait avoir déjà signé, dont la version en cours est disponible sur le site de {{ config('app.name') }}, dans la rubrique Informations légales.</p>
    <div class="mt-5">
        <div class="fw-bolder fs-2 fs-underline mb-2">ACCEPTATION DE SIGNER ELECTRONIQUEMENT ET SUPPORT DURABLE</div>
        <p>Le titulaire accepte de signer électroniquement. Il accepte dès lors de recevoir l’information précontractuelle sur un support durable autre
            que le papier. L’intégrité des documents présentés au titulaire sera assurée notamment par leur scellement et leur horodatage dès leur
            origine sur la plateforme de signature. Cette plateforme est opérée par un prestataire de services de confiance. La transmission et la
            réception de ces documents sera assurée par leur mise à disposition sur la plateforme, étant précisé que l’envoi et la réception seront
            réputés intervenir au même instant. Le titulaire aura accès à tout moment aux documents mis à sa disposition sur la plate forme. Il est
            invité à enregistrer et/ou à les imprimer.</p>
    </div>
    <div class="mt-5">
        <div class="fw-bolder fs-2 fs-underline mb-2">SIGNATURE ELECTRONIQUE – CONVENTION DE PREUVE</div>
        <p>Le dispositif de signature électronique mis en place par {{ config('app.name') }} est associé à un certificat fourni par un prestataire de services
            de confiance.</p>
        <p>Il est expressément convenu entre {{ config('app.name') }} et le Titulaire conformément à l’article 1316-2 du Code civil que:</p>
        <ol>
            <li>Pour pouvoir apposer une signature électronique, il sera demandé au titulaire, la saisie d’un Code Sécurité (qui lui aura été envoyé
                par SMS sur le téléphone portable qui a été déclaré à {{ config('app.name') }}) et/ou l’utilisation d’un Pass Sécurité. La saisie de ce code
                ou l’utilisation du Pass Sécurité dans ces conditions vaudra signature du titulaire, permettant ainsi son identification et prouvant
                son consentement.</li>
            <li>La preuve des connexions, des requêtes de signatures, des opérations factuelles ou contextuelles sera établie, en tant que de
                besoin, par les journaux de traces émanant selon le cas, des enregistrements de la plate forme du prestataire de services de
                confiance ou de {{ config('app.name') }}.</li>
            <li>Le titulaire reconnait que les documents établis et produits par voie électronique ou leur reproduction sur un support informatique
                constituent la preuve des conventions conclues par lui-même.</li>
        </ol>
        <p>En cas de contestation il appartiendra à {{ config('app.name') }} d’établir la fiabilité des éléments produits. Le titulaire pourra apporter la preuve
            contraire.</p>
    </div>
    <div class="page-break"></div>
    <div class="mt-5">
        <div class="fw-bolder fs-2 fs-underline mb-2">PARCOURS DE SIGNATURE</div>
        <p>Le titulaire se verra proposer la lecture et l’acceptation des documents précontractuels puis contractuels. Le titulaire aura la possibilité
            d’interrompre le parcours de signature et de le reprendre. Les documents à signer seront à sa disposition pendant une période de validité
            signalée par son échéance.<br>
            Avant signature il sera soumis au titulaire un récapitulatif de sa demande, ainsi que des documents qu’il aura lus et acceptés durant le
            parcours de signature. Il lui sera alors demandé, après confirmation, de les signer. Avant la signature le titulaire aura la possibilité de
            corriger sa demande en annulant celle en cours, puis selon le cas en la recaractérisant dans son espace du site {{ config('app.name') }}, ou en
            rappelant son conseiller de clientèle.</p>
    </div>
    <div class="mt-5">
        <div class="fw-bolder fs-2 fs-underline mb-2">ACCES A L’ARCHIVE</div>
        <p>Le titulaire aura en permanence un accès dédié à l’ensemble de ses documents signés dans son espace de Banque en ligne et en sera
            notifié.</p>
    </div>
    <div class="mt-5">
        <div class="fw-bolder fs-2 fs-underline mb-2">DROIT APPLICABLE – COMPETENCE</div>
        <p>La convention est soumise au droit français et à la compétence des tribunaux français.</p>
    </div>
    @isset($document)
    <table class="table table-rounded border gy-7 gs-7 m-10 w-100">
        <thead>
        <tr class="fw-bolder fs-2 text-gray-800 border-bottom border-gray-200 text-center">
            <th>Le titulaire</th>
            <th>La banque {{ $agence->name }}</th>
        </tr>
        </thead>
        <tbody>
        <tr class="h-50px">
            <td class="text-center fs-2">
                @if($document->signed_by_client)
                Signé éléctroniquement le {{ now()->format('d/m/Y') }}.<br>@if($customer->info->type == 'part') {{ $customer->info->civility.'. '. $customer->info->lastname.' '.$customer->info->firstname }} @else {{ $customer->info->company }} @endif
                @endif
            </td>
            <td class="text-center fs-2">
                @if($document->signed_by_bank)
                Signé éléctroniquement le {{ now()->format('d/m/Y') }} par la banque
                @endif
            </td>
        </tr>
        </tbody>
    </table>
    @endisset
@endsection
