<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        
        return view('user.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('user.tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $user = Auth::user();

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('tickets', 'public');
        }

        $ticketNumber = 'TCK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        $ticket = Ticket::create([
            'ticket_number' => $ticketNumber,
            'user_id' => $user->id,
            'user_identifier' => $user->username,
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $attachmentPath,
            'status' => 'open',
        ]);

        return redirect()->route('tickets.show', $ticket)
                        ->with('success', 'Pengaduan berhasil dikirim!');
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('user.tickets.show', compact('ticket'));
    }

    public function close($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $ticket->update(['status' => 'closed']);

        return redirect()->route('tickets.show', $ticket)
                        ->with('success', 'Pengaduan ditutup!');
    }
}