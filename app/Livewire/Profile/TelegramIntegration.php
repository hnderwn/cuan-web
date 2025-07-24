<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class TelegramIntegration extends Component
{
    public function generateToken()
    {
        $user = Auth::user();
        $user->telegram_token = Str::random(32);
        $user->save();
    }

    public function render()
    {
        return view('livewire.profile.telegram-integration');
    }
}
