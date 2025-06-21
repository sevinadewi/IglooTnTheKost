<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show($id)
    {
        $property = Property::findOrFail($id);
        $totalKamar = $property->rooms->count();
         // Hitung penghuni aktif dan non-aktif
        $penghuniAktif = Tenant::where('property_id', $id)
                            ->where('status', 'aktif')
                            ->count();

        $penghuniNonAktif = Tenant::where('property_id', $id)
                                ->where('status', 'non-aktif')
                                ->count();

        return view('dashboard.dashboard-index', compact(
            'property',
            'totalKamar',
            'penghuniAktif',
            'penghuniNonAktif'
        ));
        }

    public function showRooms($id)
    {
        // Ambil properti beserta semua kamarnya
    $property = Property::with('rooms')->findOrFail($id);

    // Ambil data kamar dari relasi
    $rooms = $property->rooms;

    return view('dashboard.dashboard-kamar', compact('property', 'rooms'));
    }
   

}
