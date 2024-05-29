<div>
    <a href="{{ route('v2.today-staf-report') }}" class="relative flex items-center justify-between gap-4 p-4 bg-white border rounded-lg shadow-md min-h-28">
        <div class="space-y-0">
            <div class="relative flex items-center justify-center w-16 h-16 text-2xl font-bold text-white transition duration-500 bg-green-400 border border-white border-dashed rounded-lg group hover:scale-105 hover:rotate-6 relatif ring-2 ring-green-200">
                    {{ $jumlah_absen }}
                <div class="absolute group-hover:animate-bounce flex items-center justify-center w-5 h-5 text-[8px] text-white bg-red-600 rounded-full -right-2 -bottom-2 ring-2 ring-white">
                    {{ $total_karyawan - $jumlah_absen }}
                </div>
            </div>
        </div>
        <div class="w-full gap-4 font-bold text-gray-800 ">
            <div class="flex flex-col gap-2">
                <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-lg dark:bg-gray-700">
                    <div class="h-3 bg-yellow-400 rounded-lg text-[8px] text-end pe-1" style="width: {{ $persentase_masuk_1 }}%">{{ $persentase_masuk_1 .'%' }}</div>
                </div>
                <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-lg dark:bg-gray-700">
                    <div class="h-3 bg-blue-500 rounded-lg text-[8px] text-end pe-1" style="width: {{ $persentase_masuk_2 }}%">{{ $persentase_masuk_2 .'%'}}</div>
                </div>
                <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-lg dark:bg-gray-700">
                    <div class="h-3 bg-green-400 rounded-lg text-[8px] text-end pe-1" style="width: {{ $persentase_pulang }}%">{{ $persentase_pulang .'%'}}</div>
                </div>

            </div>
            <div class="absolute flex items-center gap-2 text-xs bottom-1 right-4">
                <div class="flex items-center gap-2">
                    <div class="items-center w-2 h-2 bg-yellow-400"></div>
                    <p class="text-[8px]">Masuk 1</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-blue-500"></div>
                    <p class="text-[8px]">Masuk 2</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="items-center w-2 h-2 bg-green-400"></div>
                    <p class="text-[8px]">Pulang</p>
                </div>
            </div>
        </div>
    </a>
</div>
