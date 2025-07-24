<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\CallbackQuery; // <-- Pastikan ini di-import

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $chatId = $update->getChat()->getId();
        $user = User::where('telegram_chat_id', $chatId)->first();

        if ($update->isType('callback_query')) {
            if ($user) {
                $this->handleCallbackQuery($user, $update->getCallbackQuery());
            }
            return response()->json(['status' => 'ok']);
        }

        if ($update->has('message') && $update->getMessage()->has('text')) {
            $text = $update->getMessage()->getText();
            if (!$user) {
                $this->handleUnauthenticatedUser($chatId, $text);
                return response()->json(['status' => 'ok']);
            }
            if (substr($text, 0, 1) === '/') {
                $this->handleCommand($user, $chatId, $text);
            } else {
                $this->continueConversation($user, $chatId, $text);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    private function handleUnauthenticatedUser($chatId, $text)
    {
        if (strpos($text, '/start ') === 0) {
            $token = substr($text, 7);
            $user = User::where('telegram_token', $token)->first();
            if ($user) {
                $user->telegram_chat_id = $chatId;
                $user->telegram_state = null;
                $user->telegram_data = null;
                $user->save();
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Mantap! Akun berhasil terhubung. Coba kirim /pengeluaran untuk memulai.']);
            } else {
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Waduh, Token Rahasia tidak valid.']);
            }
        } else {
            Telegram::sendMessage(['chat_id' => $chatId, 'text' => "Halo! Untuk memulai, kirim pesan: \n/start <TOKEN_RAHASIA_DARI_WEB>"]);
        }
    }

    private function handleCommand($user, $chatId, $text)
    {
        // Reset state & data lama sebelum memulai perintah baru
        $user->update(['telegram_state' => null, 'telegram_data' => null]);

        switch ($text) {
            case '/start':
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Akunmu sudah terhubung! Coba kirim /pengeluaran']);
                break;
            case '/pengeluaran':
                $user->update([
                    'telegram_state' => 'awaiting_expense_amount',
                    'telegram_data' => json_encode(['type' => 'Pengeluaran'])
                ]);
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Oke, catat pengeluaran. Berapa jumlahnya? (Kirim /batal untuk berhenti)']);
                break;
            case '/batal':
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Oke, tidak ada aksi yang sedang berjalan.']);
                break;
            default:
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Perintah tidak dikenali. Coba /pengeluaran']);
                break;
        }
    }

    private function continueConversation($user, $chatId, $text)
    {
        // Tambahan fitur batal di tengah percakapan
        if ($text === '/batal') {
            $user->update(['telegram_state' => null, 'telegram_data' => null]);
            Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Oke, aksi dibatalkan.']);
            return;
        }

        $state = $user->telegram_state;
        $data = json_decode($user->telegram_data, true);

        switch ($state) {
            case 'awaiting_expense_amount':
                if (!is_numeric($text)) {
                    Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Jumlah harus angka ya. Coba lagi, berapa jumlahnya?']);
                    return;
                }
                $data['amount'] = $text;
                $user->update([
                    'telegram_state' => 'awaiting_expense_description',
                    'telegram_data' => json_encode($data)
                ]);
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Sip. Deskripsinya apa?']);
                break;
            case 'awaiting_expense_description':
                $data['description'] = $text;
                $categories = $user->categories()->where('transaction_type', 'Pengeluaran')->get();
                $keyboard = $categories->map(function ($category) {
                    return [['text' => $category->name, 'callback_data' => 'category_id:' . $category->id]];
                });
                $user->update([
                    'telegram_state' => 'awaiting_expense_category',
                    'telegram_data' => json_encode($data)
                ]);
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Oke. Pilih kategorinya:',
                    'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
                ]);
                break;
        }
    }

    // Ganti total isi method ini
    private function handleCallbackQuery($user, CallbackQuery $callbackQuery)
    {
        $chatId = $callbackQuery->getMessage()->getChat()->getId();
        $callbackData = $callbackQuery->getData();
        $state = $user->telegram_state;
        $data = json_decode($user->telegram_data, true);

        list($key, $value) = explode(':', $callbackData, 2);

        if ($state === 'awaiting_expense_category' && $key === 'category_id') {
            $data['category_id'] = $value;

            $paymentMethods = $user->paymentMethods()->get();
            $keyboard = $paymentMethods->map(function ($pm) {
                return [['text' => $pm->name, 'callback_data' => 'payment_method_id:' . $pm->id]];
            });

            $user->update([
                'telegram_state' => 'awaiting_expense_payment_method',
                'telegram_data' => json_encode($data)
            ]);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Oke. Dibayar pakai apa?',
                'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
            ]);
        }

        if ($state === 'awaiting_expense_payment_method' && $key === 'payment_method_id') {
            $data['payment_method_id'] = $value;

            Transaction::create([
                'user_id' => $user->id,
                'category_id' => $data['category_id'],
                'payment_method_id' => $data['payment_method_id'],
                'transaction_type' => $data['type'],
                'amount' => $data['amount'],
                'description' => $data['description'],
                'transaction_date' => now()->toDateString(),
            ]);

            $user->update(['telegram_state' => null, 'telegram_data' => null]);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Sip! Pengeluaran '{$data['description']}' sebesar Rp " . number_format($data['amount'], 0, ',', '.') . " berhasil dicatat!"
            ]);
        }

        Telegram::answerCallbackQuery(['callback_query_id' => $callbackQuery->getId()]);
    }
}
