@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Votre demande de remise bancaire</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($customer) }}</span>
            <p>Une nouvelle demande de remise bancaire à été créé le {{ $deposit->created_at->format('d/m/Y à H:i') }}.<br>Voici les informations relatives à cette demande</p>
            <table class="table table-bordered table-striped mb-5">
                <tbody>
                    <tr>
                        <td class=fw-bolder>Référence</td>
                        <td>{{ $deposit->reference }}</td>
                    </tr>
                    <tr>
                        <td class=fw-bolder>Montant</td>
                        <td>{{ eur($deposit->amount) }}</td>
                    </tr>
                    <tr>
                        <td class=fw-bolder>Compte bancaire de référence</td>
                        <td>{{ \App\Helper\CustomerWalletHelper::getNameAccount($deposit->wallet) }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="fs-4 fw-bolder">Que va-t-il se passée ensuite ?</div>
            <ul>
                <li>Veuillez nous envoyer les chèques mentionner dans votre remise à FINTECH, Service Bancaire, 85102 LES SABLES D'OLONNE 8 sous <strong>4 Jours</strong></li>
                <li>Dès récéption, vos chèques sont vérifiés par notre équipe financière et sont crédité en date saisie en ligne.</li>
            </ul>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

