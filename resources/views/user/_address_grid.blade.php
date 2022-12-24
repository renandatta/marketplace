<div class="address-card__name">{{ $address->name }}</div>
<div class="address-card__row">
    {{ $address->address }}<br />
    {{ $address->district. ', '. $address->city }}<br />
    {{ $address->province }}
    {{ $address->postal_code }}
</div>
<div class="address-card__row">
    <div class="address-card__row-title">{{ __('model.phone') }}</div>
    <div class="address-card__row-content">{{ $address->phone }}</div>
</div>
