<div x-data="{tampil:'kehadiran'}">
    <div>
        <x-admin-template>
            <button x-on:click="tampil='kehadiran'">Kehadiran</button>
            <button x-on:click="tampil='quran'">quran</button>
        </x-admin-template>
    </div>



    <div class="mt-4">

        <x-admin-template>
            <ul x-show="tampil =='quran'">
                @foreach ($surahs as $item)
                <li class="mb-2 font-arabic">{{ $item['name'] }}</li>
                @endforeach
            </ul>
            <ul x-show="tampil == 'kehadiran'">
                @forelse ($anggotaHalaqah as $item)
                <li>
                    <p>{{ $item->student->name }}</p>
                    <div class="flex">
                        <div>
                            <label for="">hadir</label>
                            <input type="radio" name="kehadiran{{ $item->id }}" value="hadir" checked>
            
                        </div>
                        <div>
                            <label for="">Sakit</label>
                            <input type="radio" name="kehadiran{{ $item->id }}" value="hadir">
                        </div>
                        <div>
                            <label for="">Izin</label>
                            <input type="radio" name="kehadiran{{ $item->id }}" value="hadir">
                        </div>
                        <div>
                            <label for="">Alpa</label>
                            <input type="radio" name="kehadiran{{ $item->id }}" value="hadir">
                        </div>
        
                    </div>
                </li>
                    
                @empty
                    
                @endforelse
            </ul>
        </x-admin-template>
    </div>

    {{-- "student_id" => 16
        "groupinghalaqah_id" => 5
        "created_at" => "2024-06-07 16:39:45"
        "updated_at" => "2024-06-07 16:39:45" --}}

        {{-- "nama_halaqah" => "Halaqah Khairuddin"
            "user_id" => 36
            "status" => 1
            "created_at" => "2024-06-07 15:29:21"
            "updated_at" => "2024-06-07 15:29:21" --}}

    

    <div class="mt-6">
        hafalan
        <ul>
            @forelse ($anggotaHalaqah as $item)
            <li>
                <p>{{ $item->student->name }}</p>
                <p>hafalan Ziyadah Terakhir</p>
            </li>
            @empty
                
            @endforelse
        </ul>
    </div>
    <div class="mt-6">
        Murajaah
        <ul>
            @forelse ($anggotaHalaqah as $item)
            <li>
                <p>{{ $item->student->name }}</p>
                <p>Murajaah Terakhir</p>
            </li>
            @empty
                
            @endforelse
        </ul>
    </div>
</div>
