<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Property;

class TenantController extends Controller
{
    public function index($propertyId)
    {
   
        $property = Property::findOrFail($propertyId);
        $tenants = Tenant::with('room')->where('property_id', $propertyId)->where('status', 'aktif')->get();
        $rooms = Room::where('property_id', $propertyId)->where('status', 'kosong')->get();

        return view('dashboard.dashboard-penghuni', compact('tenants','rooms', 'property', 'propertyId'));
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
            'telepon' => 'required|string|max:20|unique:tenants,telepon',
            'tanggal' => 'required|date',
            'email' => 'nullable|email',
            'room_id' => 'required|exists:rooms,id',
        ],[
            'telepon.unique' => 'Nomor telepon ini sudah digunakan oleh penyewa lain.'
        ]);

        $room = Room::findOrFail($request->room_id);

        Tenant::create([
            
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'tanggal' => $request->tanggal,
            'room_id' => $room->id,
            'property_id' => $room->property_id,
            'harga' => $room->harga,
            'email' => $request->email,
            'status' => 'aktif'
        ]);

        $room->update(['status' => 'terisi']);

        // return redirect()->route('dashboard.dashboard-penghuni', ['propertyId' => $room->property_id])->with('success', 'Penyewa berhasil ditambahkan');
        return redirect()->route('dashboard-penghuni', ['id' => $room->property_id])
                     ->with('success', 'Penyewa berhasil ditambahkan');
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

    public function showTenant($propertyId)
    {
        $tenants = Tenant::with('room')->where('property_id', $propertyId)->get();

        return view('dashboard.dashboard-penghuni', compact('tenants'));
    }

    public function keluar(Tenant $tenant)
    {
    $tenant->update([
        'status' => 'keluar'
    ]);

    if ($tenant->room) {
        $tenant->room->update(['status' => 'kosong']);
    }

    return redirect()->back()->with('success', 'Penyewa telah keluar kos.');
    }

}
