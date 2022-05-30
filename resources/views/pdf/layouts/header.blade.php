@if($type == 'simple')
    <header>
        <div class="logo">
            <img src="{{ config('app.url') }}/storage/logo/logo_long_color_540.png" alt="{{ $agence->name }}">
        </div>
        <span class="letter-code">{{ Str::upper(Str::random(4)) }} {{ Str::upper(Str::random(4)) }} {{ Str::upper(Str::random(4)) }} CPT{{ isset($customer->wallets()->first()->number_account)?$customer->wallets()->first()->number_account:Str::upper(Str::random(10)) }} {{ Str::upper(Str::random(5)) }} {{ Str::upper(Str::random(4)) }}</span>
        <div style="margin: 20px; text-align: left" class="fs-1 text-start">
            <strong>Agence:</strong> {{ $agence->name }}<br>
            <strong>Téléphone:</strong> {{ $agence->phone }}<br>
        </div>
    </header>
@elseif($type == 'address')
    <header>
        <div class="logo">
            <img src="{{ config('app.url') }}/storage/logo/logo_long_color_540.png" alt="{{ $agence->name }}">
        </div>
        <div style="margin: 20px; text-align: left" class="fs-1 text-start">
            <strong>Agence:</strong><br>
            {{ $agence->name }}<br>
            {{ $agence->address }}<br>
            {{ $agence->postal }} {{ $agence->city }}<br><br>
            <strong>Téléphone: </strong>{{ $agence->phone }}
        </div>
        <div class="date">Le {{ $document->created_at->format('d/m/Y') }}</div>
        <div class="address_customer">
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
    </header>
@else
    <header>
        <div class="logo">
            <img src="{{ config('app.url') }}/storage/logo/logo_long_color_540.png" alt="{{ $agence->name }}">
        </div>
        <span class="letter-code">{{ Str::upper(Str::random(4)) }} {{ Str::upper(Str::random(4)) }} {{ Str::upper(Str::random(4)) }} CPT{{ isset($customer->wallets()->first()->number_account)?$customer->wallets()->first()->number_account:Str::upper(Str::random(10)) }} {{ Str::upper(Str::random(5)) }} {{ Str::upper(Str::random(4)) }}</span>
        <div style="margin: 20px; text-align: left" class="fs-1 text-start">
            <strong>Agence:</strong> {{ $agence->name }}<br>
            <strong>Téléphone:</strong> {{ $agence->phone }}<br>
        </div>
    </header>
@endif

<div class="separator separator-dotted border-2 border-bank mb-10"></div>


