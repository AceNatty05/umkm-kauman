<x-guest-layout>
    <x-slot name="title">Verifikasi OTP — UMKM Desa Kauman</x-slot>
    <h2 class="text-2xl font-bold text-center text-kauman-primary mb-2">Verifikasi OTP</h2>
    <p class="text-center text-sm text-gray-500 mb-6">Masukkan kode 6 digit yang dikirim ke WhatsApp <strong>{{ $phone }}</strong></p>

    @if(session('otp_message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ session('otp_message') }}</div>
    @endif

    @if($debug_otp ?? false)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg mb-4 text-sm">
            <strong>🔧 Mode Development:</strong> Kode OTP Anda adalah <strong class="text-lg">{{ $debug_otp }}</strong>
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify.submit') }}">
        @csrf
        <div class="mb-6">
            <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">Kode OTP</label>
            <input id="otp" type="text" name="otp" maxlength="6" required autofocus placeholder="______"
                   class="w-full rounded-lg border-gray-300 text-center text-2xl tracking-[0.5em] font-mono focus:border-kauman-primary focus:ring-kauman-primary">
            @error('otp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="w-full bg-kauman-primary text-white py-3 rounded-lg font-semibold hover:bg-kauman-primary-dark transition-colors mb-4">Verifikasi</button>
    </form>

    <form method="POST" action="{{ route('otp.resend') }}" class="text-center">
        @csrf
        <p class="text-sm text-gray-500">Tidak menerima kode?
            <button type="submit" class="text-kauman-primary font-semibold hover:underline">Kirim Ulang</button>
        </p>
    </form>
</x-guest-layout>
