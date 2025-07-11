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

        

        return redirect()->route('dashboard-kamar', ['id' => $request->property_id])->with('success', 'Kamar berhasil ditambahkan');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $fasilitasArray = array_map('trim', explode(',', $request->input('fasilitas')));
        $request->merge(['fasilitas' => $fasilitasArray]);

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

        $room->save();

       return redirect()->back()->with('success', 'Data kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
         // Cek jika kamar sedang terisi
        if (strcasecmp($room->status, 'Terisi') === 0) {
        return back()->with('error', 'Kamar tidak bisa dihapus karena sedang terisi.');
        }

        $propertyId = $room->property_id;

        if ($room->gambar && Storage::disk('public')->exists($room->gambar)) {
            Storage::disk('public')->delete($room->gambar);
        }

        $room->delete();

        return redirect()->route('dashboard-kamar', ['id' => $propertyId])
        ->with('success', 'Kamar berhasil dihapus.');
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