<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar untuk mengambil semua tiket
        $query = Ticket::with('user')->orderBy('created_at', 'desc');
        
        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != 'all') {
            $status = $request->status;
            
            // Validasi status yang diizinkan
            if (in_array($status, ['open', 'in_progress', 'resolved', 'closed'])) {
                $query->where('status', $status);
            }
        }
        
        // Ambil data dengan pagination (10 data per halaman)
        $tickets = $query->paginate(10);
        
        // Kirim ke view admin.tickets.index
        return view('admin.tickets.index', compact('tickets'));
    }
    
    public function show($id)
    {
        $ticket = Ticket::with(['user', 'responses.user'])->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }
}