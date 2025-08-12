<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Hubungkan ke Telegram') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Hubungkan akun Anda ke bot Telegram untuk mencatat transaksi langsung dari chat.") }}
        </p>
    </header>

    <div class="mt-6 space-y-4">
        @if(Auth::user()->telegram_chat_id)
        {{-- TAMPILAN JIKA SUDAH TERHUBUNG --}}
        <div class="p-4 bg-green-100 text-green-800 rounded-lg">
            <p class="font-semibold">✅ Akun Anda sudah terhubung!</p>
            <p class="text-sm">Anda sekarang bisa mengirim perintah ke bot Telegram.</p>
        </div>
        <button
            wire:click="disconnectTelegram"
            wire:confirm="Yakin mau putuskan koneksi? Bot tidak akan bisa lagi mencatat transaksimu."
            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-transform duration-150 hover:scale-105 active:scale-95">
            Putuskan Koneksi
        </button>

        @else
        {{-- TAMPILAN JIKA BELUM TERHUBUNG --}}
        <div>
            <p class="text-sm text-gray-600">
                1. Klik tombol di bawah untuk membuat Token Rahasia.
            </p>
            <button wire:click="generateToken" class="mt-2 bg-brand-dark hover:bg-brand-darkest text-white font-bold py-2 px-4 rounded-lg transition-transform duration-150 hover:scale-105 active:scale-95">
                Buat Token
            </button>
        </div>

        @if(Auth::user()->telegram_token)
        <div
            x-data="{ 
                        token: '{{ Auth::user()->telegram_token }}', 
                        feedback: 'Salin',
                        copyToClipboard() {
                            const textToCopy = '/start ' + this.token;
                            const tempInput = document.createElement('input');
                            tempInput.style.position = 'absolute';
                            tempInput.style.left = '-9999px';
                            tempInput.value = textToCopy;
                            document.body.appendChild(tempInput);
                            tempInput.select();
                            try {
                                document.execCommand('copy');
                                this.feedback = 'Tersalin!';
                                setTimeout(() => { this.feedback = 'Salin' }, 2000);
                            } catch (err) {
                                console.error('Gagal menyalin teks: ', err);
                                alert('Oops, gagal menyalin teks!');
                            }
                            document.body.removeChild(tempInput);
                        }
                    }">
            <p class="text-sm text-gray-600 mt-4">
                2. Buka bot Telegram Anda, lalu kirim pesan berikut:
            </p>
            <div class="mt-2 p-3 bg-gray-100 rounded-lg text-sm font-mono relative">
                <code>/start {{ Auth::user()->telegram_token }}</code>

                <button @click="copyToClipboard" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800" :title="feedback">
                    {{-- Ikon Copy --}}
                    <svg x-show="feedback === 'Salin'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    {{-- Ikon Centang --}}
                    <svg x-show="feedback === 'Tersalin!'" x-cloak class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @endif
    </div>
</section>