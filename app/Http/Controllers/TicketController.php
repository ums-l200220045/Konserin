<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QRCodeOutputType;
use chillerlan\QRCode\Data\QRCodeErrorCorrectionLevel;


class TicketController extends Controller
{
    /**
     * Menangani proses pemesanan tiket konser.
     */
    public function showCheckoutForm(Request $request)
    {
        $request->validate([
            'concert_id' => 'required|exists:concerts,id',
            'quantity' => 'required|integer|min:1|max:4',
        ]);

        $concert = Concert::findOrFail($request->concert_id);
        $quantity = $request->quantity;

        return view('checkout', compact('concert', 'quantity'));
    }
    
    public function checkout(Request $request)
    {        
        // Validasi input
        $request->validate([
            'concert_id' => 'required|exists:concerts,id',
            'quantity' => 'required|integer|min:1|max:4',
            'holders' => 'required|array|min:1|max:4',
            'holders.*.name' => 'required|string|max:255',
            'holders.*.nik' => 'required|string|max:255',
            'holders.*.phone' => 'required|string|max:20',
            'metode_pembayaran' => 'required|string|in:Gopay,ShopeePay,Virtual Account,Credit Card',
        ]);

        $niks = array_column($request->holders, 'nik');
        if (count($niks) !== count(array_unique($niks))) {
            return back()->with('error', 'NIK untuk setiap tiket harus unik.');
        }

        $concert = Concert::findOrFail($request->concert_id);

        // Cek apakah kuota masih cukup
        if ($concert->quota < $request->quantity) {
            return back()->with('error', 'Kuota tiket tidak mencukupi.');
        }

        $existingCount = Ticket::where('user_id', Auth::id())
            ->where('concert_id', $concert->id)
            ->sum('quantity');

        if ($existingCount + $request->quantity > 4) {
            return back()->with('error', 'Maksimal pembelian tiket per konser adalah 4 per user.');
        }

        // Simpan tiket utama
        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'concert_id' => $concert->id,
            'quantity' => $request->quantity,
            'total_price' => $concert->price * $request->quantity,
            'status' => 'pending',
        ]);


        $options = new QROptions([
            'version'          => 7,
            'outputType'       => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'         => QRCode::ECC_L,
            'scale'            => 8,
            'margin'           => 2,
            'imageBase64'      => false,
            'imageTransparent' => false,
        ]);

        $qrcode = new QRCode($options);

        foreach ($request->holders as $holder) {
            $qrContent = "TIKET-{$ticket->id}|NIK:{$holder['nik']}|NAMA:{$holder['name']}";
            $pngData = $qrcode->render($qrContent);
            $fileName = 'qr_'.md5($qrContent).'.png';
            $path = 'qr_codes/'.$fileName;
            
            // Simpan file
            Storage::disk('public')->put($path, $pngData);

            TicketDetail::create([
                'ticket_id' => $ticket->id,
                'holder_name' => $holder['name'],
                'holder_nik' => $holder['nik'],
                'qr_code' => Storage::url($path),
            ]);
        }


        // Simpan data pembayaran
        Payment::create([
            'ticket_id' => $ticket->id,
            'method' => $request->metode_pembayaran,
            'status' => 'pending',
        ]);

        // Kurangi kuota konser
        $concert->quota -= $request->quantity;

        // Update status konser jika ada method-nya
        if (method_exists($concert, 'updateStatus')) {
            $concert->updateStatus();
        }

        $concert->save();

        return redirect('/home')->with('success', 'Tiket berhasil dipesan. Silakan lanjutkan pembayaran.');
    }

    public function userTickets()
    {
        $tickets = Ticket::with(['concert', 'payment', 'details'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('my-tickets', compact('tickets'));
    }

    public function simulatePayment($id)
    {
        $ticket = Ticket::with('payment')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Simulasi bayar hanya jika belum sukses
        if ($ticket->payment && $ticket->payment->status === 'pending') {
            $ticket->payment->update([
                'status' => 'success',
                'paid_at' => now(),
            ]);

            $ticket->update([
                'status' => 'paid',
            ]);

            return back()->with('success', 'Pembayaran berhasil disimulasikan!');
        }

        return back()->with('error', 'Pembayaran sudah dilakukan atau tidak valid.');
    }

    public function checkTicketAvailability(Request $request)
    {
        $request->validate([
            'concert_id' => 'required|exists:concerts,id',
            'quantity' => 'required|integer|min:1|max:4',
        ]);

        $concert = Concert::findOrFail($request->concert_id);

        // Cek kuota
        if ($concert->quota < $request->quantity) {
            return back()->with('error', 'Kuota tiket tidak mencukupi.');
        }

        // Cek total tiket yang pernah dibeli user
        $existing = Ticket::where('user_id', Auth::id())
            ->where('concert_id', $concert->id)
            ->sum('quantity');

        if ($existing + $request->quantity > 4) {
            return back()->with('error', 'Maksimal pembelian tiket per konser adalah 4.');
        }

        // Jika lolos semua, redirect ke checkout
        return redirect()->route('tickets.form', [
            'concert_id' => $concert->id,
            'quantity' => $request->quantity,
        ]);
    }
}