<x-admin-template>
    <ul class="divide-y-2">
        @forelse ($belumApprove as $item)
            <li>
                <div class="flex justify-between">
                    <p class="text-sm">{{ \Carbon\Carbon::parse($item->created_at)->format('l, d M Y') }}</p>
                    <p class="text-sm">{{ strtoupper(str_replace('_',' ',$item->absenkaryawandetail->type)) }}</p>
                </div>
                <p class="text-sm text-gray-600">{{ $item->keterangan }}</p>

                <button class="px-4 py-2 mt-2 text-sm text-white bg-red-700 rounded-lg">Approve</button>
            </li>
        @empty
            
        @endforelse
    </ul>
</x-admin-template>
