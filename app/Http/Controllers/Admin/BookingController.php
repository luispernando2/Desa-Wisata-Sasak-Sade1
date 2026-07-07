<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Traits\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends AdminController
{
    use LogActivity;

    public function index()
    {
        $bookings = Booking::with(['package', 'user', 'review'])
            ->orderBy('visit_date', 'desc')
            ->get();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'statusOptions' => Booking::statusOptions(),
            'statusCounts' => $bookings->countBy('status'),
        ]);
    }

    public function show(Booking $booking)
    {
        $booking->load(['package', 'user', 'review.user']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Booking::statusOptions()))],
        ], [
            'status.required' => 'Status booking wajib dipilih.',
            'status.in' => 'Status booking tidak valid.',
        ]);

        if ($booking->status === $data['status']) {
            return back()->with('success', 'Status booking tidak berubah.');
        }

        $oldValues = ['status' => $booking->status];
        $booking->update(['status' => $data['status']]);

        $this->logActivity(
            'update',
            'bookings',
            "Status booking '{$booking->name}' diubah menjadi {$booking->status_label}",
            $booking->id,
            $oldValues,
            ['status' => $booking->status]
        );

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        if (! $booking->isCompleted()) {
            return back()->with('error', 'Booking hanya bisa dihapus setelah statusnya Selesai.');
        }

        $bookingId = $booking->id;
        $packageTitle = $booking->package?->title ?? 'Paket tidak diketahui';
        $oldValues = $booking->toArray();

        $booking->delete();

        $this->logActivity(
            'delete',
            'bookings',
            "Booking untuk paket '{$packageTitle}' dihapus",
            $bookingId,
            $oldValues,
            null
        );

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}
