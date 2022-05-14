@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Clients</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}"
                   class="text-muted text-hover-primary">Agence: {{ auth()->user()->agency->name }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.index') }}" class="text-muted text-hover-primary">Clients</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.show', $wallet->customer->id) }}" class="text-muted text-hover-primary">Client: {{ \App\Helper\CustomerHelper::getName($wallet->customer) }}
                    - {{ $wallet->customer->user->identifiant }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.wallet.show', [$wallet->customer->id, $wallet->id]) }}" class="text-muted text-hover-primary">{{ \App\Helper\CustomerWalletHelper::getTypeWallet($wallet->type, false) }} N°{{ $wallet->number_account }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Relever d'identité Bancaire</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="d-flex justify-content-end mb-10">
        <button id="print" class="btn btn-primary">Imprimer le Rib</button>
    </div>
    <div class="card" id="cardRib">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between mb-5">
                <div class="d-flex flex-column">
                    <img src="/storage/logo/logo_long_color.png" class="w-100px" alt="">
                    <div class="mt-8">
                        <span class="fw-bolder text-gray-400">Titulaire du compte</span>
                        <p class="fw-bold fs-4">
                            {{ $wallet->customer->info->civility }}. {{ $wallet->customer->info->firstname }} {{ $wallet->customer->info->lastname }}<br>
                            {{ $wallet->customer->info->address }}<br>
                            @isset($wallet->customer->info->addressbis)
                                {{ $wallet->customer->info->addressbis }}<br>
                            @endisset
                            {{ $wallet->customer->info->postal }} {{ $wallet->customer->info->city }}
                        </p>
                    </div>
                </div>
                <div class="d-flex flex-column bg-gray-300 p-5 w-50">
                    <span class="fw-bolder fs-4">Relevé d’Identité Bancaire</span>
                    <p class="text-gray-500">
                        Ce relevé est destiné à être remis, sur leur demande, à vos créanciers ou
                        débiteurs appelés à faire inscrire des opérations à votre compte (virements,
                        paiements de quittances, etc.).<br>
                        Son utilisation vous garantit le bon enregistrement des opérations en cause et
                        vous évite ainsi des réclamations pour erreurs ou retards d'imputation.
                    </p>
                </div>
            </div>
            <table class="table mb-6">
                <thead>
                    <tr class="text-gray-400 fs-4 border-bottom border-bottom-2 border-gray-200">
                        <th>IBAN</th>
                        <th>BIC</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $wallet->iban }}</td>
                        <td>{{ $wallet->customer->user->agency->bic }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table mb-6">
                <thead>
                <tr class="text-gray-400 fs-4 border-bottom border-bottom-2 border-gray-200">
                    <th>Code Banque</th>
                    <th>Code Guichet</th>
                    <th>Numéro de compte</th>
                    <th>Clé RIB</th>
                    <th>Domiciliation</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $wallet->customer->user->agency->code_banque }}</td>
                    <td>{{ $wallet->customer->user->agency->code_agence }}</td>
                    <td>{{ $wallet->number_account }}</td>
                    <td>{{ $wallet->rib_key }}</td>
                    <td>
                        {{ $wallet->customer->user->agency->address }}<br>
                        {{ $wallet->customer->user->agency->postal }} {{ $wallet->customer->user->agency->city }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("script")
    <script type="text/javascript">
        let contentPrint = document.querySelector('#cardRib').innerHTML

        $("#print").on('click', e => {
            e.preventDefault()
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />');
            a.document.write('<body >');
            a.document.write(contentPrint);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        })
    </script>
@endsection
