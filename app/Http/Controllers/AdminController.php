<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index()
    {

        $concerts = Concert::where('admin_id', Auth::id())->get();

        return view('dashboard.admin.konser', compact('concerts'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric',
            'quota' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Simpan konser terlebih dahulu TANPA gambar
        $concert = Concert::create([
            'name' => $validated['name'],
            'venue' => $validated['venue'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'price' => $validated['price'],
            'quota' => $validated['quota'],
            'description' => $validated['description'] ?? null,
            'status' => 'active',
            'admin_id' => Auth::id(),
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'konser' . $concert->id . '.' . $extension;

            // Simpan di public/images/concert
            $file->move(public_path('images/concert'), $filename);

            // Simpan path ke DB
            $concert->image = 'images/concert/' . $filename;
            $concert->save();
        }

        // Update status sesuai kuota & tanggal
        $concert->updateStatus();

        return redirect()->back()->with('success', 'Konser berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $concert = Concert::where('admin_id', Auth::id())->findOrFail($id);
        return view('dashboard.admin.edit-konser', compact('concert'));
    }

    public function update(Request $request, $id)
    {
        $concert = Concert::where('admin_id', Auth::id())->findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric',
            'quota' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Update data konser
        $concert->update([
            'name' => $validated['name'],
            'venue' => $validated['venue'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'price' => $validated['price'],
            'quota' => $validated['quota'],
            'description' => $validated['description'] ?? null,
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'konser' . $concert->id . '.' . $extension;

            // Hapus gambar lama jika ada
            if ($concert->image && File::exists(public_path($concert->image))) {
                File::delete(public_path($concert->image));
            }

            // Simpan gambar baru
            $file->move(public_path('images/concert'), $filename);
            $concert->image = 'images/concert/' . $filename;
            $concert->save();
        }

        // Update status sesuai kuota & tanggal
        $concert->updateStatus();

        return redirect()->route('dashboard.admin.konser')->with('success', 'Konser berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $concert = Concert::where('admin_id', Auth::id())->findOrFail($id);

        // Hapus file gambar pamflet jika ada
        if ($concert->image && File::exists(public_path($concert->image))) {
            File::delete(public_path($concert->image));
        }

        // Hapus data konser dari database
        $concert->delete();

        return redirect()->back()->with('success', 'Konser berhasil dihapus.');
    }

}
