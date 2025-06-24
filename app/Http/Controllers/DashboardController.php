<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        
                                
        // Ambil data per bulan
        $tenantsPerMonth = Tenant::selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan")
            ->where('property_id', $id)
            ->where('status', 'aktif')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->map(function ($item) use ($id) {
                $penghuni = Tenant::where('property_id', $id)
                    ->where('status', 'aktif')
                    ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$item->bulan])
                    ->count();

                $pemasukan = Tenant::where('property_id', $id)
                    ->where('status', 'aktif')
                    ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$item->bulan])
                    ->sum('harga');

                return [
                    'bulan' => Carbon::parse($item->bulan . '-01')->translatedFormat('F Y'),
                    'jumlah_penghuni' => $penghuni,
                    'total_pemasukan' => $pemasukan,
                ];
            });

        return view('dashboard.dashboard-index', compact(
            'property',
            'totalKamar',
            'penghuniAktif',
            'penghuniNonAktif',
            'tenantsPerMonth'
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
