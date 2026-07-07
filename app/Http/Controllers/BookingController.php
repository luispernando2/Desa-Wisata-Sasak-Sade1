<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PackageTour;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required','string','max:30','regex:/^\+?[0-9\s\-\.]+$/'],
            'package_id' => 'required|exists:package_tours,id',
            'visit_date' => 'required|date|after_or_equal:today',
            'guests' => 'required|integer|min:1|max:100',
            'message' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Alamat email tidak valid.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.max' => 'Nomor WhatsApp tidak boleh lebih dari 30 karakter.',
            'phone.regex' => 'Nomor WhatsApp hanya boleh berisi angka, spasi, tanda plus, titik, atau strip.',
            'package_id.required' => 'Silakan pilih paket wisata.',
            'package_id.exists' => 'Paket wisata yang dipilih tidak ditemukan.',
            'visit_date.required' => 'Tanggal kunjungan wajib diisi.',
            'visit_date.date' => 'Format tanggal kunjungan tidak valid.',
            'visit_date.after_or_equal' => 'Tanggal kunjungan harus hari ini atau setelahnya.',
            'guests.required' => 'Jumlah pengunjung wajib diisi.',
            'guests.integer' => 'Jumlah pengunjung harus berupa angka.',
            'guests.min' => 'Jumlah pengunjung minimal 1 orang.',
            'guests.max' => 'Jumlah pengunjung maksimal 100 orang.',
            'message.max' => 'Catatan tidak boleh lebih dari 1000 karakter.',
        ]);

        $package = PackageTour::find($data['package_id']);

        if (! $request->session()->has('auth_user')) {
            return redirect()->route('login')->with('error', 'Silakan login atau daftar terlebih dahulu untuk melakukan booking.');
        }

        $bookingData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'package_id' => $data['package_id'],
            'visit_date' => $data['visit_date'],
            'guests' => $data['guests'],
            'message' => $data['message'] ?? '',
            'user_id' => $request->session()->get('auth_user.id'),
            'status' => Booking::STATUS_PENDING,
        ];

        $booking = Booking::create($bookingData);

        $text = "Halo Admin Sasak Sade,\n\nSaya ingin melakukan booking paket wisata di Desa Sasak Sade.\n\nNama: {$booking->name}\nEmail: {$booking->email}\nPhone: {$booking->phone}\nPaket: " . ($package->title ?? 'Tidak tersedia') . "\nTanggal Kunjungan: {$booking->visit_date}\nJumlah Pengunjung: {$booking->guests}\nCatatan: {$booking->message}\n\nMohon informasi pembayaran transfer untuk booking ini.";
        $whatsappNumber = '6287865936972';
        $encoded = rawurlencode($text);

        return redirect()->away("https://wa.me/{$whatsappNumber}?text={$encoded}");
    }
}
