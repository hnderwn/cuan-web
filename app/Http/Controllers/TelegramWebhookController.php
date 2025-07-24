<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\CallbackQuery;
use Carbon\Carbon;
use Telegram\Bot\Keyboard\Keyboard;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $update = Telegram::getWebhookUpdate();
            $chatId = $update->getChat()->getId();
            $user = User::where('telegram_chat_id', $chatId)->first();

            if ($update->isType('callback_query')) {
                if ($user) $this->handleCallbackQuery($user, $update->getCallbackQuery());
            } elseif ($update->has('message') && $update->getMessage()->has('text')) {
                $text = $update->getMessage()->getText();
                if (!$user) {
                    $this->handleUnauthenticatedUser($chatId, $text);
                } else {
                    if (substr($text, 0, 1) === '/') {
                        $this->handleCommand($user, $chatId, $text);
                    } else {
                        $this->continueConversation($user, $chatId, $text);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Telegram Webhook Error: ' . $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine());
        } finally {
            return response()->json(['status' => 'ok']);
        }
    }


    private function sendMainMenu($chatId, $text)
    {
        $keyboard = [
            [['text' => '💸 Catat Pengeluaran', 'callback_data' => 'menu:pengeluaran']],
            [['text' => '💰 Catat Pemasukan', 'callback_data' => 'menu:pemasukan']],
            [['text' => '❓ Bantuan', 'callback_data' => 'menu:help']],
        ];

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
        ]);
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
                $this->sendMainMenu($chatId, 'Mantap! Akun berhasil terhubung. Silakan gunakan tombol di bawah untuk memulai.');
            } else {
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Waduh, Token Rahasia tidak valid.']);
            }
        } else {
            Telegram::sendMessage(['chat_id' => $chatId, 'text' => "Halo! Untuk memulai, kirim pesan: \n/start <TOKEN_RAHASIA_DARI_WEB>"]);
        }
    }


    private function handleCommand($user, $chatId, $text)
    {
        $user->update(['telegram_state' => null, 'telegram_data' => null]);
        switch ($text) {
            case '/start':
                $this->sendMainMenu($chatId, 'Akunmu sudah terhubung! Silakan gunakan tombol di bawah.');
                break;
            case '/pengeluaran':
            case '/pemasukan':
                $type = ($text === '/pengeluaran') ? 'Pengeluaran' : 'Pemasukan';
                $user->update([
                    'telegram_state' => 'awaiting_amount',
                    'telegram_data' => json_encode(['type' => $type])
                ]);
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => "Oke, catat {$type}. Berapa jumlahnya?\n(Contoh: 25000)\n\nKirim /batal untuk berhenti."]);
                break;
            case '/batal':
                $this->sendMainMenu($chatId, 'Oke, tidak ada aksi yang sedang berjalan.');
                break;
            case '/help':
                $helpText = "*Bantuan Cuan-Web Bot* 🤖\n\n" .
                    "Gunakan tombol di bawah atau kirim perintah:\n\n" .
                    "➡️ `/pengeluaran` - Catat pengeluaran.\n" .
                    "➡️ `/pemasukan` - Catat pemasukan.\n" .
                    "➡️ `/batal` - Batalkan proses.\n" .
                    "➡️ `/help` - Tampilkan bantuan ini.";
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => $helpText, 'parse_mode' => 'Markdown']);
                break;
            case '/menu':
                $this->sendMainMenu($chatId, 'Menampilkan menu utama.');
                break;
            default:
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Perintah tidak dikenali.']);
                break;
        }
    }

    private function continueConversation($user, $chatId, $text)
    {
        if ($text === '/batal') {
            $user->update(['telegram_state' => null, 'telegram_data' => null]);
            $this->sendMainMenu($chatId, 'Oke, aksi dibatalkan.');
            return;
        }
        $state = $user->telegram_state;
        $data = json_decode($user->telegram_data, true);
        switch ($state) {
            case 'awaiting_amount':
                if (!is_numeric($text)) {
                    Telegram::sendMessage(['chat_id' => $chatId, 'text' => "Jumlah harus angka ya. Coba lagi.\n(Contoh: 25000)"]);
                    return;
                }
                $data['amount'] = $text;
                $user->update(['telegram_state' => 'awaiting_description', 'telegram_data' => json_encode($data)]);
                Telegram::sendMessage(['chat_id' => $chatId, 'text' => "Sip. Deskripsinya apa?\n(Contoh: Kopi Susu Gula Aren)"]);
                break;
            case 'awaiting_description':
                $data['description'] = $text;
                $user->update(['telegram_state' => 'awaiting_date', 'telegram_data' => json_encode($data)]);
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Oke. Untuk tanggal berapa transaksi ini?\n\n(Ketik tanggal jika mau tanggal lain, contoh: 2025-07-25)",
                    'reply_markup' => json_encode(['inline_keyboard' => [
                        [['text' => 'Hari Ini', 'callback_data' => 'date:today']],
                        [['text' => 'Kemarin', 'callback_data' => 'date:yesterday']],
                    ]])
                ]);
                break;
            case 'awaiting_date':
                try {
                    $data['date'] = Carbon::parse($text)->toDateString();
                    $this->askCategory($user, $chatId, $data);
                } catch (\Exception $e) {
                    Telegram::sendMessage(['chat_id' => $chatId, 'text' => "Format tanggal salah. Coba lagi.\n(Contoh: 2025-07-25 atau 25-07-2025)"]);
                }
                break;
            case 'awaiting_notes':
                $data['notes'] = $text;
                $this->askConfirmation($user, $chatId, $data);
                break;
        }
    }

    private function handleCallbackQuery($user, CallbackQuery $callbackQuery)
    {
        $chatId = $callbackQuery->getMessage()->getChat()->getId();
        $callbackData = $callbackQuery->getData();
        $state = $user->telegram_state;
        $data = json_decode($user->telegram_data, true);
        list($key, $value) = explode(':', $callbackData, 2);
        if ($key === 'menu') {
            switch ($value) {
                case 'pengeluaran':
                case 'pemasukan':
                    $type = ($value === 'pengeluaran') ? 'Pengeluaran' : 'Pemasukan';
                    $user->update([
                        'telegram_state' => 'awaiting_amount',
                        'telegram_data' => json_encode(['type' => $type])
                    ]);
                    Telegram::sendMessage(['chat_id' => $chatId, 'text' => "Oke, catat {$type}. Berapa jumlahnya?\n(Contoh: 25000)\n\nKirim /batal untuk berhenti."]);
                    break;
                case 'help':
                    $helpText = "*Bantuan Cuan-Web Bot* 🤖\n\n" .
                        "Gunakan tombol di bawah atau kirim perintah:\n\n" .
                        "➡️ `/pengeluaran` - Catat pengeluaran.\n" .
                        "➡️ `/pemasukan` - Catat pemasukan.\n" .
                        "➡️ `/batal` - Batalkan proses.\n";
                    Telegram::sendMessage(['chat_id' => $chatId, 'text' => $helpText, 'parse_mode' => 'Markdown']);
                    break;
            }
        }

        switch ($state) {
            case 'awaiting_date':
                if ($key === 'date') {
                    $data['date'] = ($value === 'today') ? now()->toDateString() : now()->subDay()->toDateString();
                    $this->askCategory($user, $chatId, $data);
                }
                break;
            case 'awaiting_category':
                if ($key === 'category_id') {
                    $data['category_id'] = $value;
                    $this->askPaymentMethod($user, $chatId, $data);
                }
                break;
            case 'awaiting_payment_method':
                if ($key === 'payment_method_id') {
                    $data['payment_method_id'] = $value;
                    $this->askNotes($user, $chatId, $data);
                }
                break;
            case 'awaiting_notes':
                if ($key === 'notes' && $value === 'skip') {
                    $data['notes'] = null;
                    $this->askConfirmation($user, $chatId, $data);
                }
                break;
            case 'awaiting_confirmation':
                if ($key === 'confirmation') {
                    if ($value === 'save') {
                        $this->saveTransaction($user, $data);
                        Telegram::editMessageText(['chat_id' => $chatId, 'message_id' => $callbackQuery->getMessage()->getMessageId(), 'text' => "Sip! Transaksi berhasil dicatat!"]);
                        $this->sendSuccessSummary($user, $chatId, $data);
                    } else {
                        $user->update(['telegram_state' => null, 'telegram_data' => null]);
                        Telegram::editMessageText(['chat_id' => $chatId, 'message_id' => $callbackQuery->getMessage()->getMessageId(), 'text' => 'Oke, aksi dibatalkan.']);
                        $this->sendMainMenu($chatId, 'Silakan pilih menu lagi.');
                    }
                }
                break;
        }
        Telegram::answerCallbackQuery(['callback_query_id' => $callbackQuery->getId()]);
    }

    private function askCategory($user, $chatId, $data)
    {
        $categories = $user->categories()->where('transaction_type', $data['type'])->get();
        if ($categories->isEmpty()) {
            Telegram::sendMessage(['chat_id' => $chatId, 'text' => "Waduh, kamu belum punya kategori untuk {$data['type']}. Silakan buat dulu di web ya."]);
            $user->update(['telegram_state' => null, 'telegram_data' => null]);
            return;
        }
        $keyboard = $categories->chunk(2)->map(function ($chunk) {
            return $chunk->map(function ($category) {
                return ['text' => $category->name, 'callback_data' => 'category_id:' . $category->id];
            })->values()->all();
        })->values()->all();

        $user->update(['telegram_state' => 'awaiting_category', 'telegram_data' => json_encode($data)]);
        Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Sip. Pilih kategorinya:', 'reply_markup' => json_encode(['inline_keyboard' => $keyboard])]);
    }

    private function askPaymentMethod($user, $chatId, $data)
    {
        $paymentMethods = $user->paymentMethods()->get();
        $keyboard = $paymentMethods->chunk(2)->map(function ($chunk) {
            return $chunk->map(function ($pm) {
                return ['text' => $pm->name, 'callback_data' => 'payment_method_id:' . $pm->id];
            })->values()->all();
        })->values()->all();

        $user->update(['telegram_state' => 'awaiting_payment_method', 'telegram_data' => json_encode($data)]);
        Telegram::sendMessage(['chat_id' => $chatId, 'text' => 'Oke. Dibayar pakai apa?', 'reply_markup' => json_encode(['inline_keyboard' => $keyboard])]);
    }

    private function askNotes($user, $chatId, $data)
    {
        $user->update(['telegram_state' => 'awaiting_notes', 'telegram_data' => json_encode($data)]);
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "Ada catatan tambahan?\n(Ketik catatan atau lewati)",
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'Lewati', 'callback_data' => 'notes:skip']]]])
        ]);
    }



    private function askConfirmation($user, $chatId, $data)
    {
        $categoryName = \App\Models\Category::find($data['category_id'])->name;
        $pmName = \App\Models\PaymentMethod::find($data['payment_method_id'])->name;

        $summary = "Siap? Ini detailnya:\n\n" .
            "Tipe: *{$data['type']}*\n" .
            "Tanggal: *" . Carbon::parse($data['date'])->format('d M Y') . "*\n" .
            "Jumlah: *Rp " . number_format($data['amount'], 0, ',', '.') . "*\n" .
            "Deskripsi: *{$data['description']}*\n" .
            "Kategori: *{$categoryName}*\n" .
            "Metode Bayar: *{$pmName}*\n" .
            "Catatan: *" . ($data['notes'] ?? '-') . "*";

        $keyboard = [[
            ['text' => '✅ Simpan', 'callback_data' => 'confirmation:save'],
            ['text' => '❌ Ulangi', 'callback_data' => 'confirmation:cancel']
        ]];

        $user->update(['telegram_state' => 'awaiting_confirmation', 'telegram_data' => json_encode($data)]);
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $summary,
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
        ]);
    }

    private function saveTransaction($user, $data)
    {
        Transaction::create([
            'user_id' => $user->id,
            'category_id' => $data['category_id'],
            'payment_method_id' => $data['payment_method_id'],
            'transaction_type' => $data['type'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'transaction_date' => $data['date'],
            'notes' => $data['notes'] ?? null,
        ]);

        $user->update(['telegram_state' => null, 'telegram_data' => null]);
    }

    private function sendSuccessSummary($user, $chatId, $data)
    {
        $categoryName = Category::find($data['category_id'])->name;
        $pmName = PaymentMethod::find($data['payment_method_id'])->name;

        $summary = "✅ *Transaksi Berhasil Dicatat!*\n\n" .
            "----------------------------------------\n" .
            "Deskripsi: *{$data['description']}*\n" .
            "Jumlah: *Rp " . number_format($data['amount'], 0, ',', '.') . "*\n" .
            "Tanggal: *" . Carbon::parse($data['date'])->format('d M Y') . "*\n" .
            "Kategori: *{$categoryName}*\n" .
            "Metode Bayar: *{$pmName}*\n" .
            "Catatan: *" . ($data['notes'] ?? '-') . "*\n" .
            "----------------------------------------";

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $summary,
            'parse_mode' => 'Markdown',
        ]);

        // Kirim menu utama setelahnya
        $this->sendMainMenu($chatId, 'Mau catat apa lagi?');
    }
}
