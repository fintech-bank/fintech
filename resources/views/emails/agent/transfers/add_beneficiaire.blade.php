@extends("emails.layouts.agent")

@section('content')
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5 pt-5">
            <p>Un nouveau bénéficiaire à été ajouté:</p>
            <table>
                <tbody>
                <tr>
                    <td>Client</td>
                    <td>
                        <strong>{{ \App\Helper\CustomerHelper::getName($customer) }}</strong><br>
                        <i>{{ $wallet->number_account }} / {{ $wallet->iban }}</i>
                    </td>
                </tr>
                <tr>
                    <td>Bénéficiaire</td>
                    <td>
                        <strong>{{ \App\Helper\CustomerTransferHelper::getNameBeneficiaire($beneficiaire) }}</strong><br>
                        <i>{{ $beneficiaire->iban }} / {{ $beneficiaire->banknbame }}</i>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection
