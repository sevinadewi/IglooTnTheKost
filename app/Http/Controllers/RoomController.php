<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        
        $rooms = Room::all();
        // Perbaiki compact agar passing 'rooms', bukan 'tenants'
        return view('rooms.index', compact( 'rooms' ));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
         // Ubah string fasilitas jadi array (trim tiap elemen)
    $fasilitasArray = array_map('trim', explode(',', $request->input('fasilitas')));

    // Ganti input fasilitas jadi array supaya validasi array bisa jalan
    $request->merge(['fasilitas' => $fasilitasArray]);
    
        Log::info('Room store request:', $request->all());
    

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'nama' => 'required|string|max:255',
            'fasilitas' => 'required|array',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'harga' => 'required|integer',
            'status' => 'required|string',
        ]);

        // Simpan gambar ke storage publik
        $gambarPath = $request->file('gambar')->store('gambar_kamar', 'public');

        // Simpan data kamar ke DB
        Room::create([
            'property_id' => $request->property_id,
            'nama' => $request->nama,
            'fasilitas' => $request->fasilitas, // array akan otomatis diserialisasi ke JSON
            'gambar' => $gambarPath,
            'harga' => $request->harga,
            'status' => $request->status,
        ]);

        // Set session currentStep agar step 3 aktif saat reload halaman
        session(['currentStep' => 3]);

        return redirect()->route('property.index')->with('success', 'Kamar berhasil ditambahkan');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'nama' => 'required|string|max:255',
            'fasilitas' => 'required|array',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'harga' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($request->hasFile('gambar')) {
            if ($room->gambar && Storage::disk('public')->exists($room->gambar)) {
                Storage::disk('public')->delete($room->gambar);
            }

            $gambarBaru = $request->file('gambar')->store('gambar_kamar', 'public');
            $room->gambar = $gambarBaru;
        }

        $room->update([
            'property_id' => $request->property_id,
            'nama' => $request->nama,
            'fasilitas' => $request->fasilitas,
            'harga' => $request->harga,
            'status' => $request->status,
            'gambar' => $room->gambar,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil diperbarui');
    }

    public function destroy(Room $room)
    {
        if ($room->gambar && Storage::disk('public')->exists($room->gambar)) {
            Storage::disk('public')->delete($room->gambar);
        }

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil dihapus');
    }

    public function dashboardViewByProperty($propertyId)
{
    $property = \App\Models\Property::with('rooms')->findOrFail($propertyId);
    $rooms = $property->rooms;

    return view('dashboard.dashboard-kamar', compact('property', 'rooms'));
}


    public function listByProperty($propertyId)
    {
    // Ambil semua kamar berdasarkan properti tertentu
    $rooms = Room::where('property_id', $propertyId)->get();

    return view('dashboard.dashboard-kamar', compact('rooms'));
    }


}