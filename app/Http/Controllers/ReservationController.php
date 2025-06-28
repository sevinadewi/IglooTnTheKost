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
        $rooms = Room::where('property_id', $propertyId)->get();

        return view('dashboard.dashboard-pemesanan', compact('reservations','property','rooms'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date|after:today',
            'email' => 'nullable|email',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $tanggalMasuk = $request->tanggal_masuk;

        $existingReservation = Reservation::where('room_id', $request->room_id)->where('status', '!=', 'cancelled')->where('tanggal_masuk', $tanggalMasuk)->first();
        if ($existingReservation) {
            return redirect()->back()->with('error', 'Kamar sudah dipesan pada tanggal ini');
        }

        Reservation::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'tanggal_masuk' => $tanggalMasuk,
            'room_id' => $request->room_id,
            'property_id' => $request->property_id,
            'catatan' => $request->catatan,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Pemesanan berhasil dicatatat');
    }

    public function accept(Reservation $reservation)
    {
        $room = $reservation->room;

        if ($room->status == 'kosong') {
            Tenant::create([
                'nama' => $reservation->nama,
                'telepon' => $reservation->telepon,
                'tanggal' => $reservation->tanggal_masuk,
                'email' => $reservation->email,
                'room_id' => $reservation->room_id,
                'property_id' => $reservation->property_id,
                'harga' => $room->harga,
                'status' => 'aktif'
            ]);

            $room->update(['status' => 'terisi']);
            $reservation->update(['status' => 'booked']);

            return redirect()->back()->with('success', 'Pemesanan diterima, sudah menjadi penyewa.');
        } else {
            return redirect()->back()->with('error', 'Kamar masih terisi. Penyewa sebelumnya belum keluar.');
        }
    }
}
