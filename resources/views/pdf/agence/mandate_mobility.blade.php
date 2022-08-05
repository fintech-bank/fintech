@extends('pdf.layouts.app')

@section("content")
    <div class="card card-flush shadow-sm rounded-3 border mb-15">
        <div class="card-body ">
            <div class="fw-bolder fs-3">
                Mandat de mobilité bancaire<br>
                Mandat N°{{ $data->mobility->mandate }}
            </div>
        </div>
    </div>
    <div class="mb-10">Entre</div>
    <div class="mb-5 fw-bolder">Titulaire 1</div>
    <table class="table border gy-7 gs-7 mb-10" style="border-color: #000">
        <tbody>
            <tr>
                <td>
                    {{ \App\Helper\CustomerHelper::getName($data->mobility->customer) }}<br>
                    Né le {{ $data->mobility->customer->info->datebirth->format('d/m/Y') }} à {{ $data->mobility->customer->info->citybirth }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Demeurant à:</strong><br>
                    {{ $data->mobility->customer->info->address }}<br>
                    @isset($data->mobility->customer->info->addressbis)
                        {{ $data->mobility->customer->info->addressbis }}<br>
                    @endisset
                    {{ $data->mobility->customer->info->postal }} {{ $data->mobility->customer->info->city }}

                </td>
            </tr>
            <tr>
                <td>
                    <strong>Courriel:</strong> {{ $data->mobility->customer->user->email }}<br>
                    <strong>Téléphone Portable:</strong> {{ $data->mobility->customer->info->mobile }}
                    @isset($data->mobility->customer->info->phone)
                        <br>
                        <strong>Téléphone fixe:</strong> {{ $data->mobility->customer->info->phone }}
                    @endisset
                </td>
            </tr>
        </tbody>
    </table>
    <div class="m-5 fw-bolder fs-6"><u>Etablissement de départ</u></div>
    <table class="table border gy-7 gs-7 mb-10" style="border-color: #000">
        <tbody>
        <tr>
            <td>
                <strong>IBAN: </strong>{{ $data->mobility->old_iban }}<br>
                <strong>Etablissement:</strong> {{ $data->mobility->bank->name }}<br>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="m-5 fw-bolder fs-6"><u>Etablissement d'arrivé</u></div>
    <table class="table border gy-7 gs-7 mb-10" style="border-color: #000">
        <tbody>
        <tr>
            <td>
                <strong>IBAN: </strong>{{ $data->mobility->wallet->iban }}<br>
                <strong>Etablissement:</strong> {{ $data->mobility->customer->agency->name }}<br>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="m-5 fw-bolder fs-6"><u>Options de transfert</u></div>
    <table class="table border gy-7 gs-7 mb-10" style="border-color: #000">
        <tbody>
        <tr>
            <td>
                <strong>Clotûre du compte de départ:</strong>
                {{ $data->mobility->close_account == 0 ? 'NON' : 'OUI' }}<br>
                @isset($data->mobility->end_prlv)
                    <strong>Date de fin des virements permanents:</strong> {{ $data->mobility->env_prlv->format('d/m/Y') }}<br>
                @endisset
                <strong>Date de fin de la procédure (Prévu):</strong> {{ $data->mobility->end_prov->format('d/m/Y') }}
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
