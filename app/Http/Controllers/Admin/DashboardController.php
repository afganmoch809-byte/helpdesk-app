<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

public function index()
{
    $totalTickets = Ticket::count();
    $openTickets = Ticket::where('status', 'open')->count();
    $inProgressTickets = Ticket::where('status', 'in_progress')->count();
    $resolvedTickets = Ticket::where('status', 'resolved')->count();
    $recentTickets = Ticket::orderby('created_at', 'desc')->limit(5)->get();
    
    return view('admin.dashboard.index', compact(
        'totalTickets', 
        'openTickets', 
        'inProgressTickets', 
        'resolvedTickets',
        'recentTickets'
    ));
    }
}