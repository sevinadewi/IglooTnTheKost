<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $reservations = Reservation::with('room')->where('property_id', $propertyId)->get();

        return view('dashboard.dashboard-pemesanan', compact('reservations','property'));
    }

    public function create($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $rooms = Room::where('property_id', $propertyId)->get();

        return view('reservations.create', compact('rooms', 'property'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date|after:today',
            'email' => 'nullable|email',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $room = Room::findOrFail($request->room_id);

        Reservation::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'tanggal_masuk' => $request->tanggal_masuk,
            'room_id' => $room->id,
            'property_id' => $room->property_id,
            'catatan' => $request->catatan,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Pemesanan berhasil dicatatat');
    }

    public function accept(Reservation $reservation)
    {
        Tenant::create([
            'nama' => $reservation->nama,
            'telepon' => $reservation->telepon,
            'email' => $reservation->email,
            'tanggal' => now(),
            'room_id' => $reservation->room_id,
            'property_id' => $reservation->property_id,
            'harga' => $reservation->room->harga,
            'status' => 'aktif'
        ]);

        $reservation->room->update(['status'=>'terisi']);

        $reservation->update(['status' =>'booked']);

        return redirect()->back()->with('success', 'Pemesanan diterima dan menjadi penyewa aktif');
    }
}
