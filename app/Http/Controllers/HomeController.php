<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $trendingConcerts = Concert::withCount(['tickets as tickets_count' => function($query) {
            $query->select(DB::raw('count(ticket_details.id)'))
                  ->join('ticket_details', 'tickets.id', '=', 'ticket_details.ticket_id');
        }])
            ->where('start_date', '>', now())
            ->orderByDesc('tickets_count')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('homeutama', compact('trendingConcerts'));
    }
}
