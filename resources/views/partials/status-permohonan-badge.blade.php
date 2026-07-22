@php
    $statusText = $status ?: 'Dalam tindakan';
    $statusKey = mb_strtolower($statusText);
    $statusClass = match ($statusKey) {
        'diluluskan' => 'bg-emerald-100 text-emerald-800 ring-emerald-600/20',
        'tidak diluluskan' => 'bg-red-100 text-red-800 ring-red-600/20',
        default => 'bg-amber-100 text-amber-800 ring-amber-600/20',
    };
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusClass }}">
    {{ $statusText }}
</span>
