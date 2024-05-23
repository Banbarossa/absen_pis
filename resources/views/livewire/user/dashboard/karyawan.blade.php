<div>
    Absen Terakhir
    <ul class="divide-y-2">
        @forelse ($absen as $item)
            <li>{{ $item->created_at }}</li>
        @empty
            <li>{{ __('Data Not Found') }}</li>
        @endforelse
    </ul>
</div>
