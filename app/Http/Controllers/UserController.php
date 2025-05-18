<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = Concert::query();

        // Filter status agar hanya konser yang belum berakhir
        $query->where('status', '!=', 'ended');

        // Jika ada pencarian nama konser
        if ($request->has('q') && $request->q !== '') {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // Ambil hasil dengan urutan tanggal terdekat
        $concerts = $query->orderBy('start_date', 'asc')->get();

        return view('daftarkonser', compact('concerts'));
    }


    public function show($id)
    {
        $concert = Concert::findOrFail($id);
        return view('detailkonser', compact('concert'));
    }

    public function search(Request $request)
    {
        $concerts = Concert::where('status', '!=', 'ended')
            ->where('name', 'like', '%' . $request->q . '%')
            ->orderBy('start_date')
            ->get();

        return view('partials.concert-list', compact('concerts'));
    }

}
