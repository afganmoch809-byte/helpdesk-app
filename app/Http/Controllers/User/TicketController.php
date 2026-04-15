<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())
                        ->latest()
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

        // Generate ticket number
        $ticketNumber = 'TCK-' . date('Ymd') . '-' . strtoupper(uniqid());

        $ticket = Ticket::create([
            'ticket_number' => $ticketNumber,
            'user_id' => Auth::id(),
            'user_identifier' => $user->username, // NIM/NIP/NIK dari username
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $attachmentPath,
            'status' => 'open',
        ]);

        return redirect()->route('tickets.show', $ticket)
                        ->with('success', 'Pengaduan berhasil dikirim! Nomor tiket: ' . $ticketNumber);
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('user.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('user.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $ticket->update($request->only(['title', 'description']));

        return redirect()->route('tickets.show', $ticket)
                        ->with('success', 'Pengaduan berhasil diupdate!');
    }

    public function destroy(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
        $ticket->delete();
        
        return redirect()->route('tickets.index')
                        ->with('success', 'Pengaduan berhasil dihapus!');
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