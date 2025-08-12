<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramIntegration extends Component
{
    public function generateToken()
    {
        $user = Auth::user();
        $user->telegram_token = Str::random(32);
        $user->save();
    }

    public function disconnectTelegram()
    {
        $user = Auth::user();

        // Kirim pesan perpisahan ke Telegram jika chat_id ada
        if ($user->telegram_chat_id) {
            try {
                Telegram::sendMessage([
                    'chat_id' => $user->telegram_chat_id,
                    'text' => 'Koneksi dengan akun web Cuan-Web telah diputuskan. Untuk menghubungkan kembali, silakan buat token baru di halaman profil.'
                ]);
            } catch (\Exception $e) {
                // Abaikan error jika bot tidak bisa kirim pesan (misal, diblokir user)
            }
        }

        // Hapus data koneksi dari database
        $user->telegram_chat_id = null;
        $user->telegram_token = null;
        $user->save();
    }

    public function render()
    {
        return view('livewire.profile.telegram-integration');
    }
}
