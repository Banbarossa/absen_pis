<div class="w-full">
    <h3>{{ __('Absen Terakhir') }}</h3>
    <ul class="divide-y-2 divide-gray-300 dark:divide-gray-700">
        @forelse ($absen as $item)
            <li>
                {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->format('l, d-M-Y') }}
                <div class="grid grid-cols-3 gap-4 mb-4">
                    @foreach ($item->absenkaryawandetails as $item)
                        <div class="flex items-center justify-between rounded bg-gray-50 dark:bg-gray-800">
                            <a href="">
                                <img src="{{asset('storage/public/images/karyawan/'. $item->image)}}" class="w-20 h-20 rounded-lg" alt="">
                            </a>
                            <p>{{ $item->image }}</p>
                            <p class="text-2xl text-gray-400 dark:text-gray-500">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                </svg>
                            </p>
                        </div>
                    @endforeach
                </div>
            </li>
        @empty
            <li>{{ __('Data Not Found') }}</li>
        @endforelse
    </ul>
</div>
