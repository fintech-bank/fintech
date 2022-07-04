@extends('pdf.layouts.app')

@section("content")
    <p class="mb-3">Nous avons enregistré l'opération suivante:</p>
    <div class="text-center text-uppercase fw-bolder fs-3 mb-10">Virement Occasionnel SEPA</div>

    <table class="table table-borderless border-0 gy-7 gx-7 mb-5">
        <tbody>
            <tr class="border border-0">
                <td class="fw-bolder text-underline"><u>Emmetteur:</u></td>
                <td class="">{{ \App\Helper\CustomerHelper::getName($data['transfer']['wallet']['customer']) }}</td>
                <td class="">Numéro de compte:</td>
                <td class="">{{ $data['transfer']['wallet']['number_account'] }}</td>
            </tr>
            <tr class="mb-15">
                <td class="fw-bolder text-underline"><u>Bénéficiaire:</u></td>
                <td class="">{{ \App\Helper\CustomerTransferHelper::getNameBeneficiaire($data['transfer']['beneficiaire']) }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-borderless border-0 gy-2 gx-2">
        <tbody>
            <tr>
                <td class="">Banque:</td>
                <td class="">{{ $data['transfer']['beneficiaire']['bank']['name'] }}</td>
            </tr>
            <tr>
                <td class="">IBAN:</td>
                <td class="">
                    {{ $data['transfer']['beneficiaire']['iban'] }}
                </td>
            </tr>
            <tr>
                <td class="">BIC:</td>
                <td class="">
                    {{ $data['transfer']['beneficiaire']['bic'] }}
                </td>
            </tr>
            <tr>
                <td class="">Référence:</td>
                <td class="fw-bolder">
                    {{ $data['transfer']['reference'] }}
                </td>
            </tr>
        </tbody>
    </table>
    <p class="fw-bolder"><u>Caractéristique du virement</u></p>
    <table class="table table-borderless border-0 gy-2 gx-2">
        <tbody>
            <tr>
                <td class="">Date d'éxecution:</td>
                <td class="fw-bolder">{{ \Carbon\Carbon::createFromTimestamp(strtotime($data['transfer']['transfer_date']))->format('d/m/Y') }}</td>
                <td class="">Montant:</td>
                <td class="fw-bolder">{{ eur($data['transfer']['amount']) }}</td>
            </tr>
            <tr>
                <td class="">Ref Banque:</td>
                <td class="fw-bolder">{{ $data['transfer']['reference'] }}</td>
            </tr>
        </tbody>
    </table>
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
