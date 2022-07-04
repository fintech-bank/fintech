@extends('pdf.layouts.app')

@section("content")
    <div class="courier uppercase">
        <div class="text-center mb-5">
            Releve du {{ \App\Helper\CustomerWalletHelper::getTypeWallet($data['wallet']['type']) }} en euro<br>
            de {{ \App\Helper\CustomerHelper::getName($customer) }}
        </div>
        <table style="width: 95%;" class="mb-10">
            <tbody>
                <tr>
                    <td style="width: 35px; text-align: right">{{ $data['wallet']['number_account'] }}</td>
                    <td style="width: 35px; text-align: center ">Relever au {{ now()->format('d/m/Y') }}</td>
                </tr>
            </tbody>
        </table>
        IBAN {{ $data['wallet']['iban'] }}<br>
        BIC {{ $agence->bic }}

        <table class="table mt-5 mb-5">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Libelle/Reference</th>
                    <th>NUM.OPE</th>
                    <th>Val</th>
                    <th>Débit</th>
                    <th>Crédit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="text-center">SOLDE {{ $data['sum_first_name'] }} au {{ $data['start']->format('d/m/Y') }}</td>
                    <td class="text-end">
                        @if($data['sum_first'] < 0)
                            {{ eur($data['sum_first']) }}
                        @endif
                    </td>
                    <td class="text-end">
                        @if($data['sum_first'] > 0)
                            {{ eur($data['sum_first']) }}
                        @endif
                    </td>
                </tr>
                @foreach($data['transactions'] as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('dm') }}</td>
                        <td>
                            {{ $transaction->designation }}
                            @if($transaction->description != null)
                                <br>
                                {{ $transaction->description }}
                            @endif
                        </td>
                        <td>{{ Str::upper(Str::limit($transaction->uuid, 8, '')) }}</td>
                        <td>
                            {{ $transaction->confirmed ? $transaction->confirmed_at->format('dm') : '' }}
                        </td>
                        <td>
                            @if($transaction->amount < 0)
                                {{ eur($transaction->amount) }}
                            @endif
                        </td>
                        <td>
                            @if($transaction->amount > 0)
                                {{ eur($transaction->amount) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="4">SOLDE {{ $data['sum_last_name'] }} au {{ $data['end']->format('d/m/Y') }}</td>
                        <td class="text-end">
                            @if($data['wallet']->balance_actual < 0)
                                {{ eur($data['wallet']->balance_actual) }}
                            @endif
                        </td>
                        <td class="text-end">
                            @if($data['wallet']->balance_actual > 0)
                                {{ eur($data['wallet']->balance_actual) }}
                            @endif
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
    <div class="courier">
        *  Sous réserve des opérations en cours d'enregistrement et d'une provision suffisante et disponible lors de l'arrêté du solde du compte réalisé en fin de journée.
    </div>
@endsection
