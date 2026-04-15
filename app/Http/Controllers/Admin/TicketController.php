<?php

namespace App\Http\Controllers\Admin;  // <-- Namespace yang benar

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,closed,completed',
        ]);

        $ticket->update(['status' => $request->status]);

        return redirect()->route('admin.tickets.show', $ticket)
                        ->with('success', 'Status tiket berhasil diupdate!');
    }

}