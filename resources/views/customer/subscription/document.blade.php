@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Validation des documents bancaires</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('customer.dashboard') }}" class="text-muted text-hover-primary">{{ \App\Helper\CustomerHelper::getName($mobility->customer) }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('customer.subscription.index') }}" class="text-muted text-hover-primary">Souscription</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="#" class="text-muted text-hover-primary">Mandat de mobilité N°{{ $mobility->mandate }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Validation des documents bancaires</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="alert alert-primary d-flex align-items-center p-5">
        <!--begin::Icon-->
        <i class="fa-solid fa-circle-info fa-2x text-primary me-3"></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-1 text-primary">Informations</h4>
            <!--end::Title-->
            <!--begin::Content-->
            <p>Afin de finaliser l'import des mouvements bancaires lié à votre précédente banque, vous devez valider chacun des documents ci-dessous.</p>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <div class="card card-flush shadow-sm mb-10">
        <div class="card-header">
            <h3 class="card-title">Prélèvements Bancaires</h3>
            <div class="card-toolbar">
                @if($mobility->prlvs()->count() != $mobility->prlvs()->where('valid', 1)->count())
                <button class="btn btn-sm btn-success btnValidAllPrlv"><i class="fa-solid fa-check me-2"></i> Valider tous les prélèvements</button>
                @endif
            </div>
        </div>
        <div class="card-body py-5">
            <table class="table table-striped border gy-5 gs-5">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>Créditeur</th>
                        <th>Numéro de Mandat</th>
                        <th>Montant</th>
                        <th class="text-center">Validé</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mobility->prlvs as $prlv)
                        <tr>
                            <td>{{ $prlv->creditor }}</td>
                            <td>{{ $prlv->number_mandate }}</td>
                            <td>{{ eur($prlv->amount) }}</td>
                            <td class="text-center">{!! $prlv->isValid() !!}</td>
                            <td class="text-end">
                                @if(!$prlv->valid)
                                    <a href="" class="btn btn-sm btn-icon btn-success btnValidatePrlv" data-prlv="{{ $prlv->id }}"><i class="fa-solid fa-check"></i> </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-flush shadow-sm mb-10">
        <div class="card-header">
            <h3 class="card-title">Virements Entrants</h3>
            <div class="card-toolbar">
                @if($mobility->incomings()->count() != $mobility->incomings()->where('valid', 1)->count())
                    <button class="btn btn-sm btn-success btnValidAllIncoming"><i class="fa-solid fa-check me-2"></i> Valider tous les virements entrants</button>
                @endif
            </div>
        </div>
        <div class="card-body py-5">
            <table class="table table-striped border gy-5 gs-5">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>Designation</th>
                        <th>Référence</th>
                        <th>Montant</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th class="text-center">Validé</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mobility->incomings as $inc)
                        <tr>
                            <td>{{ $inc->reason }}</td>
                            <td>{{ $inc->reference }}</td>
                            <td>{{ eur($inc->amount) }}</td>
                            <td>{{ \App\Helper\CustomerTransferHelper::getTypeTransfer($inc->type) }}</td>
                            <td>
                                @if($inc->type == 'immediat')
                                    {{ $inc->transfer_date->format("d/m/Y") }}
                                @elseif($inc->type == 'differed')
                                    {{ $inc->transfer_date->format("d/m/Y") }}
                                @else
                                    <strong>Début:</strong> {{ $inc->recurring_start->format("d/m/Y") }}<br>
                                    <strong>Fin:</strong> {{ $inc->recurring_end->format("d/m/Y") }}
                                @endif
                            </td>
                            <td class="text-center">{!! $inc->isValid() !!}</td>
                            <td class="text-end">
                                @if(!$inc->valid)
                                    <a href="" class="btn btn-sm btn-icon btn-success btnValidateIncoming" data-incoming="{{ $inc->id }}"><i class="fa-solid fa-check"></i> </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-flush shadow-sm mb-10">
        <div class="card-header">
            <h3 class="card-title">Virements Sortants</h3>
            <div class="card-toolbar">
                @if($mobility->outgoings()->count() != $mobility->outgoings()->where('valid', 1)->count())
                    <button class="btn btn-sm btn-success btnValidAllOutgoing"><i class="fa-solid fa-check me-2"></i> Valider tous les virements sortants</button>
                @endif
            </div>
        </div>
        <div class="card-body py-5">
            <table class="table table-striped border gy-5 gs-5">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>Designation</th>
                        <th>Référence</th>
                        <th>Montant</th>
                        <th>Date</th>
                        <th class="text-center">Validé</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mobility->outgoings as $inc)
                        <tr>
                            <td>{{ $inc->reason }}</td>
                            <td>{{ $inc->reference }}</td>
                            <td>{{ eur($inc->amount) }}</td>
                            <td>{{ $inc->transfer_date->format("d/m/Y") }}</td>
                            <td class="text-center">{!! $inc->isValid() !!}</td>
                            <td class="text-end">
                                @if(!$inc->valid)
                                    <a href="" class="btn btn-sm btn-icon btn-success btnValidateOutgoing" data-outgoing="{{ $inc->id }}"><i class="fa-solid fa-check"></i> </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-flush shadow-sm mb-10">
        <div class="card-header">
            <h3 class="card-title">Chèques Emmis</h3>
            <div class="card-toolbar">
                @if($mobility->cheques()->count() != $mobility->cheques()->where('valid', 1)->count())
                    <button class="btn btn-sm btn-success btnValidAllCheque"><i class="fa-solid fa-check me-2"></i> Valider tous les virements entrants</button>
                @endif
            </div>
        </div>
        <div class="card-body py-5">
            <table class="table table-striped border gy-5 gs-5">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>Numéro</th>
                        <th>Montant</th>
                        <th>Au nom de</th>
                        <th>Date d'encaissement</th>
                        <th class="text-center">Validé</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mobility->cheques as $inc)
                        <tr>
                            <td>{{ $inc->number }}</td>
                            <td>{{ eur($inc->amount) }}</td>
                            <td>{{ $inc->creditor }}</td>
                            <td>{{ $inc->date_enc->format("d/m/Y") }}</td>
                            <td class="text-center">{!! $inc->isValid() !!}</td>
                            <td class="text-end">
                                @if(!$inc->valid)
                                    <a href="" class="btn btn-sm btn-icon btn-success btnValidateCheck" data-check="{{ $inc->id }}"><i class="fa-solid fa-check"></i> </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.subscription.document")
@endsection
