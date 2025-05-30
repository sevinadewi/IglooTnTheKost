<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('room')->get();
        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'kosong')->get();
        return view('tenants.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'tanggal' => 'required|date',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $room = Room::findOrFail($request->room_id);

        Tenant::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'tanggal' => $request->tanggal,
            'room_id' => $room->id,
            'harga' => $room->harga,
        ]);

        $room->update(['status' => 'terisi']);

        return redirect()->route('property.index')->with('success', 'Penyewa berhasil ditambahkan');
    }

    public function edit(Tenant $tenant)
    {
        $rooms = Room::where('status', 'kosong')->orWhere('id', $tenant->room_id)->get();
        return view('tenants.edit', compact('tenant', 'rooms'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'tanggal' => 'required|date',
            'room_id' => 'required|exists:rooms,id',
        ]);

        if ($tenant->room_id != $request->room_id) {
            $oldRoom = Room::find($tenant->room_id);
            if ($oldRoom) {
                $oldRoom->update(['status' => 'kosong']);
            }

            $newRoom = Room::findOrFail($request->room_id);
            $newRoom->update(['status' => 'terisi']);
            $tenant->harga = $newRoom->harga;
        }

        $tenant->update([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'tanggal' => $request->tanggal,
            'room_id' => $request->room_id,
            'harga' => $tenant->harga,
        ]);

        return redirect()->route('tenants.index')->with('success', 'Data penyewa berhasil diperbarui');
    }

    public function destroy(Tenant $tenant)
    {
        if ($tenant->room) {
            $tenant->room->update(['status' => 'kosong']);
        }

        $tenant->delete();

        return redirect()->route('tenants.index')->with('success', 'Penyewa berhasil dihapus');
    }
}
