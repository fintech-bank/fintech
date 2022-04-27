@extends('pdf.layouts.app')

@section("content")
    <table class="table gy-5 gx-5 gs-5 mb-10" style="width: 100%; border: #fff">
        <tbody>
        <tr>
            <td style="width: 50%;">
                <span class="fw-bold fs-4 text-gray-600 mb-5">Titulaire du compte</span>
                <div class="fw-bold">
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
                </div>
            </td>
            <td style="width: 50%;">
                <span class="fw-bold fs-4 mb-5">Relevé d’Identité Bancaire</span>
                <p class="text-gray-400 fs-1">
                    Ce relevé est destiné à être remis, sur leur demande, à vos créanciers ou
                    débiteurs appelés à faire inscrire des opérations à votre compte (virements,
                    paiements de quittances, etc.).<br>
                    Son utilisation vous garantit le bon enregistrement des opérations en cause et
                    vous évite ainsi des réclamations pour erreurs ou retards d'imputation.
                </p>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="table border gy-5 gx-5 gs-5 mb-20" style="width: 100%;">
        <tbody>
        <tr class="">
            <td class="fw-bold text-gray-600">IBAN</td>
            <td class="fw-bold text-gray-600">BIC</td>
        </tr>
        <tr class="bg-gray-200">
            <td>{{ $data['wallet']->iban }}</td>
            <td>{{ $agence->bic }}</td>
        </tr>
        </tbody>
    </table>
    <table class="table border gy-5 gx-5 gs-5" style="width: 100%;">
        <tbody>
        <tr class="">
            <td class="fw-bold text-gray-600">Code Banque</td>
            <td class="fw-bold text-gray-600">Code Guichet</td>
            <td class="fw-bold text-gray-600">Numéro de compte</td>
        </tr>
        <tr class="bg-gray-200">
            <td>{{ $agence->code_banque }}</td>
            <td>{{ $agence->code_agence }}</td>
            <td>{{ $data['wallet']->number_account }}</td>
        </tr>
        </tbody>
    </table>
    <div class="separator separator-dashed border-gray-600 my-10"></div>
    <table class="table gy-5 gx-5 gs-5 mb-10" style="width: 100%; border: #fff">
        <tbody>
        <tr>
            <td style="width: 50%;">
                <span class="fw-bold fs-4 text-gray-600 mb-5">Titulaire du compte</span>
                <div class="fw-bold">
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
                </div>
            </td>
            <td style="width: 50%;">
                <span class="fw-bold fs-4 mb-5">Relevé d’Identité Bancaire</span>
                <p class="text-gray-400 fs-1">
                    Ce relevé est destiné à être remis, sur leur demande, à vos créanciers ou
                    débiteurs appelés à faire inscrire des opérations à votre compte (virements,
                    paiements de quittances, etc.).<br>
                    Son utilisation vous garantit le bon enregistrement des opérations en cause et
                    vous évite ainsi des réclamations pour erreurs ou retards d'imputation.
                </p>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="table border gy-5 gx-5 gs-5 mb-20" style="width: 100%;">
        <tbody>
        <tr class="">
            <td class="fw-bold text-gray-600">IBAN</td>
            <td class="fw-bold text-gray-600">BIC</td>
        </tr>
        <tr class="bg-gray-200">
            <td>{{ $data['wallet']->iban }}</td>
            <td>{{ $agence->bic }}</td>
        </tr>
        </tbody>
    </table>
    <table class="table border gy-5 gx-5 gs-5" style="width: 100%;">
        <tbody>
        <tr class="">
            <td class="fw-bold text-gray-600">Code Banque</td>
            <td class="fw-bold text-gray-600">Code Guichet</td>
            <td class="fw-bold text-gray-600">Numéro de compte</td>
        </tr>
        <tr class="bg-gray-200">
            <td>{{ $agence->code_banque }}</td>
            <td>{{ $agence->code_agence }}</td>
            <td>{{ $data['wallet']->number_account }}</td>
        </tr>
        </tbody>
    </table>
@endsection
