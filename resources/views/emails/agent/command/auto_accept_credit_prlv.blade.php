@extends("emails.layouts.agent")

@section('content')
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5 pt-5">
            <p>Commande exécuté</p>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bolder">Commande</td>
                        <td>autoAcceptCreditPrlv</td>
                    </tr>
                    <tr>
                        <td class="fw-bolder">Description</td>
                        <td>Acceptation automatique des prélèvement créditeur</td>
                    </tr>
                    <tr>
                        <td class="fw-bolder">Résultat</td>
                        <td>{{ $resultat }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection
