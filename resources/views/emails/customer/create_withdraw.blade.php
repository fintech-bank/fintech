@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-primary d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Votre demande de retrait bancaire</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($customer) }}</span>
            <p>
                Une nouvelle demande de retrait bancaire à été émise le <strong>{{ $withdraw->created_at->format('d/m/Y à H:i') }}</strong>.<br>
                Voici les informations relatives à cette demande:
            </p>
            <div class="fs-2 fw-bolder mb-5">Information sur le retrait</div>
            <table class="table table-bordered table-striped gy-7 mb-10">
                <tbody>
                    <tr>
                        <td class="fw-bolder">Référence:</td>
                        <td>{{ $withdraw->reference }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bolder">Montant:</td>
                        <td>{{ eur($withdraw->amount) }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bolder">Compte de retrait:</td>
                        <td>{{ $withdraw->wallet->number_account }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="fs-2 fw-bolder mb-5">Information sur le distributeur</div>
            <div class="d-flex flex-row w-100">
                <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $withdraw->dab->address_format }}&size=400x800&maptype=roadmap&markers=color:black|{{ $withdraw->dab->address_format }}&key={{ config('services.google.api_key') }}" alt="" class="w-50 me-5">
                <div class="w-50">
                    <table class="table table-bordered table-striped gy-7 mb-10">
                        <tbody>
                            <tr>
                                <td class="fw-bolder">Enseigne</td>
                                <td>{{ $withdraw->dab->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bolder">Adresse</td>
                                <td>{{ $withdraw->dab->address_format }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bolder">Ce distributeur est-il ouvert actuellement ?</td>
                                <td>{!! $withdraw->dab->status_format !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

