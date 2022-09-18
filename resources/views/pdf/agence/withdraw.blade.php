@extends('pdf.layouts.app')

@section("content")
    <p class="mb-3">Nous avons enregistré l'opération suivante:</p>
    <div class="text-center text-uppercase fw-bolder fs-3 mb-10">Retrait bancaire</div>

    <table class="table table-borderless border-0 gy-7 gx-7 mb-5">
        <tbody>
            <tr class="border border-0">
                <td class="fw-bolder text-underline"><u>Emmetteur:</u></td>
                <td class="">{{ \App\Helper\CustomerHelper::getName($customer) }}</td>
                <td class="">Numéro de compte:</td>
                <td class="">{{ $data->withdraw->wallet->number_account }}</td>
            </tr>
        </tbody>
    </table>
    <p class="fw-bolder"><u>Caractéristique du retrait bancaire</u></p>
    <table class="table table-borderless border-0 gy-2 gx-2">
        <tbody>
            <tr>
                <td class="">Date de la demande:</td>
                <td class="fw-bolder">{{ \Carbon\Carbon::createFromTimestamp(strtotime($data->withdraw->created_at))->format('d/m/Y') }}</td>
                <td class="">Montant:</td>
                <td class="fw-bolder">{{ eur($data->withdraw->amount) }}</td>
            </tr>
            <tr>
                <td class="">Ref Banque (A transmettre lors du retrait):</td>
                <td class="fw-bolder">{{ $data->withdraw->reference }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-rounded border gy-7 gs-7 m-10 w-100">
        <thead>
        <tr class="fw-bolder fs-3 text-gray-800 border-bottom border-gray-200 text-center">
            <th>Le titulaire</th>
            <th>La banque {{ $agence->name }}</th>
        </tr>
        </thead>
        <tbody>
        <tr class="h-50px">
            <td class="text-center fs-2">
                Signé éléctroniquement le {{ now()->format('d/m/Y') }}.<br>@if($customer->info->type == 'part') {{ $customer->info->civility.'. '. $customer->info->lastname.' '.$customer->info->firstname }} @else {{ $customer->info->company }} @endif
            </td>
            <td class="text-center fs-2">
                Signé éléctroniquement le {{ now()->format('d/m/Y') }} par la banque
            </td>
        </tr>
        </tbody>
    </table>
@endsection
