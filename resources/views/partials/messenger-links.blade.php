@php
    $messengers = [
        ['label' => 'تلگرام', 'url' => 'https://t.me/talalive'],
        ['label' => 'روبیکا', 'url' => 'https://rubika.ir/talalive'],
        ['label' => 'بله', 'url' => 'https://ble.ir/talalive'],
    ];
    $chipClass = $chipClass ?? 'inline-flex items-center gap-1.5 min-h-11 px-3.5 py-2 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-semibold';
@endphp
@foreach($messengers as $messenger)
    <a href="{{ $messenger['url'] }}" target="_blank" rel="noopener noreferrer" class="{{ $chipClass }}">
        @include('partials.ui-icon', ['name' => 'send', 'class' => 'w-3.5 h-3.5 shrink-0'])
        <span>{{ $messenger['label'] }}</span>
    </a>
@endforeach
