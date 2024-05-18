@php
    $now = \Carbon\Carbon::now();
@endphp

<time class="text-center ">
    <div class="text-sm">{{ \Carbon\Carbon::parse($now)->format('l, d F Y') }}</div>
    <div class="flex justify-center text-4xl font-extrabold">
        <div id="jam"></div>
        <div id="menit"></div>
        <div id="detik"></div>
    </div>
@push('script')
    <script>
        window.setTimeout("waktu()",1000);
        function waktu(){
            var waktu = new Date();
            setTimeout("waktu()",1000);
            document.getElementById('jam').innerHTML=waktu.getHours()+' : ';
            document.getElementById('menit').innerHTML=waktu.getMinutes()+' : ';
            document.getElementById('detik').innerHTML=waktu.getSeconds();
        }
    </script>
@endpush
</time>