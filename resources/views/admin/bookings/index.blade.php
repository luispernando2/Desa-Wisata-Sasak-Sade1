@extends('admin.layout')

@section('title', 'Kelola Booking')
@section('subtitle', 'Pantau booking, konfirmasi via WhatsApp, ubah status kunjungan, dan arsipkan booking selesai')

@section('content')
    @php
        $summaryCards = [
            ['label' => 'Menunggu', 'status' => \App\Models\Booking::STATUS_PENDING, 'icon' => 'bi-hourglass-split', 'class' => 'text-warning'],
            ['label' => 'Dikonfirmasi', 'status' => \App\Models\Booking::STATUS_CONFIRMED, 'icon' => 'bi-calendar-check', 'class' => 'text-primary'],
            ['label' => 'Selesai', 'status' => \App\Models\Booking::STATUS_COMPLETED, 'icon' => 'bi-check-circle', 'class' => 'text-success'],
            ['label' => 'Dibatalkan', 'status' => \App\Models\Booking::STATUS_CANCELLED, 'icon' => 'bi-x-circle', 'class' => 'text-danger'],
        ];
    @endphp

    <div class="row g-3 mb-4">
        @foreach($summaryCards as $card)
            <div class="col-sm-6 col-xl-3">
                <div class="badge-count">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <div class="label">{{ $card['label'] }}</div>
                            <div class="number">{{ $statusCounts->get($card['status'], 0) }}</div>
                        </div>
                        <i class="bi {{ $card['icon'] }} fs-3 {{ $card['class'] }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Pemesan</th>
                        <th>Paket</th>
                        <th>Tanggal</th>
                        <th>Pengunjung</th>
                        <th>Status</th>
                        <th>Review</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $booking->name }}</div>
                                <div class="small text-muted">{{ $booking->email }}</div>
                                <div class="small text-muted">
                                    <i class="bi bi-whatsapp text-success"></i> {{ $booking->phone }}
                                </div>
                            </td>
                            <td>{{ $booking->package?->title ?? 'Paket tidak tersedia' }}</td>
                            <td>{{ $booking->visit_date?->format('d M Y') ?? '-' }}</td>
                            <td>{{ $booking->guests }}</td>
                            <td style="min-width: 230px;">
                                <span class="badge {{ $booking->status_badge_class }} mb-2">{{ $booking->status_label }}</span>
                                <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" aria-label="Ubah status booking {{ $booking->name }}">
                                        @foreach($statusOptions as $value => $label)
                                            <option value="{{ $value }}" @selected($booking->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Simpan status">
                                        <i class="bi bi-check2"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                @if($booking->review)
                                    <span class="badge bg-success"><i class="bi bi-star-fill"></i> Sudah</span>
                                @elseif($booking->canBeReviewed())
                                    <span class="badge bg-info text-dark">Bisa review</span>
                                @else
                                    <span class="badge bg-light text-dark">Terkunci</span>
                                @endif
                            </td>
                            <td class="text-end actions-cell">
                                @if($booking->whatsapp_url)
                                    <a href="{{ $booking->whatsapp_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-success me-2">
                                        <i class="bi bi-whatsapp"></i> Chat
                                    </a>
                                @endif
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn-detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                @if($booking->isCompleted())
                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus booking selesai ini? Data review terkait juga akan terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn-delete text-muted" disabled title="Tandai Selesai sebelum menghapus booking">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada booking.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
