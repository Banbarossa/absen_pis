<div >
    <x-admin-template>

        <div x-data="{tab:'active'}" class="mb-6 text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px">
                <li class="me-2" >
                    <a href="#" x-on:click="tab = 'active'" class="inline-block p-2 border-b-2 rounded-t-lg" :class = "tab =='active' ? ' text-red-700  border-red-700' :'text-gray-600 border-gray-600'">Aktive</a>
                </li>
                <li class="me-2" >
                    <a href="#" x-on:click="tab = 'inactive'" class="inline-block p-2 border-b-2 rounded-t-lg" :class = "tab =='inactive' ? ' text-red-700  border-red-700' :'text-gray-600 border-gray-600'" >User Tidak Aktif</a>
                </li>
            </ul>
            <div x-show="tab == 'active'">
                <x-user-table :users="$ActiveUsers"></x-user-table>
            </div>
            <div x-show="tab == 'inactive'">
                <x-user-table :users="$inActiveUsers"></x-user-table>
            </div>
        </div>


        @push('script')
            <script>
                function copyText() {
                    var copyText = document.getElementById("textTarget");

                    copyText.select();
                    copyText.setSelectionRange(0, 99999);

                    navigator.clipboard.writeText(copyText.value);
                    Swal.fire("Text berhasil di Copy!");
                }

            </script>            
        @endpush

    </x-admin-template>
    
</div>
