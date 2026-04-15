<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $totalTickets = Ticket::where('user_id', $userId)->count();
        $completedTickets = Ticket::where('user_id', $userId)
                                 ->whereIn('status', ['resolved', 'closed'])
                                 ->count();
        
        return view('user.profile.index', compact('totalTickets', 'completedTickets'));
    }

    // Tampilkan form edit profil
    public function edit()
    {
        return view('user.profile.edit');
    }

    // Update profil
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
        ]);

        $user->update([
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil berhasil dilengkapi!');
    }
}