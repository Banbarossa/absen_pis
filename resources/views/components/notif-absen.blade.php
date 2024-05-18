    {{-- Audio --}}
    <audio id="notif-error">
        <source src="{{ asset('assets/voice/gagal.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notif-success">
        <source src="{{ asset('assets/voice/berhasil.mp3') }}" type="audio/mpeg">
    </audio>

    {{-- session --}}
    @if (session('success'))
        <div id="success-message" data-message="{{ session('success') }}"></div>
    @endif

    @if (session('error'))
        <div id="error-message" data-message="{{ session('error') }}"></div>
    @endif
