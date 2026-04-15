@extends('layouts.metronic')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Semua Pengaduan Saya</h3>
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                <i class="ki-outline ki-plus"></i> Buat Pengaduan Baru
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-row-dashed align-middle">
                    <thead>
                        <tr class="fs-7 fw-bold text-gray-500">
                            <th>No. Tiket</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td>
                                <span class="fw-bold">{{ $ticket->ticket_number }}</span>
                            </td>
                            <td>{{ $ticket->title }}</td>
                            <td>
                            @php
                                $statusColors = [
                                    'open' => 'primary',
                                    'in_progress' => 'warning',
                                    'resolved' => 'success',
                                    'closed' => 'secondary'
                                ];
                                $statusTexts = [
                                    'open' => 'Open',
                                    'in_progress' => 'In Progress',
                                    'resolved' => 'Resolved',
                                    'closed' => 'Closed'
                                ];
                            @endphp
                        <span class="badge badge-{{ $statusColors[$ticket->status] }} px-3 py-2">
                            {{ $statusTexts[$ticket->status] }}
                        </span>
                            </td>
                            <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-light">
                                    <i class="ki-outline ki-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">Belum ada pengaduan.</div>
                                <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-primary mt-3">
                                    Buat Pengaduan Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $tickets->links() }}
        </div>
    </div>
</div>
@endsection