<div x-data="{type:'nonApproval'}">
    <x-admin-template>
        <div class="mb-6 bg-white border-b border-gray-200 rounded-lg ">
            <ul class="flex flex-wrap gap-4 mb-4 text-sm font-medium text-center">
                <li class="me-2">
                    <button x-on:click="type = 'nonApproval'" class="inline-block rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="type=='nonApproval' ?'border-b-2 text-red-700 border-red-700':''"  type="button" >Belum Di Proses</button>
                </li>
                <li class="me-2">
                    <button x-on:click="type='approved'" class="inline-block rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="type=='approved' ?'border-b-2 text-red-700 border-red-700':''" type="button">Sudah Disetujui</button>
                </li>
                <li class="me-2">
                    <button x-on:click="type = 'denied'" class="inline-block rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="type=='denied' ?'border-b-2 text-red-700 border-red-700':''" >Ditolak</button>
                </li>
            </ul>
        </div>

        <div x-show="type == 'nonApproval'">
            <x-halaqah.list-complain :models="$models" showButton="true"></x-halaqah.list-complain>
        </div>
        <div x-show="type == 'approved'">
            <livewire:new-admin.halaqah.complain.complain-approved></livewire:new-admin.halaqah.complain.complain-approved>
        </div>
        <div x-show="type == 'denied'">
            <livewire:new-admin.halaqah.complain.complain-denied></livewire:new-admin.halaqah.complain.complain-denied>
        </div>

            
    </x-admin-template>
</div>
