<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Tenant;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Request $request, $propertyId)
{
    $property = Property::findOrFail($propertyId);

    $bulan = $request->input('bulan') ?? date('m');
    $tahun = $request->input('tahun') ?? date('Y');

    // Ambil tenant aktif dari properti
    $tenants = Tenant::where('property_id', $propertyId)->get();

    foreach ($tenants as $tenant) {

        if (!$tenant->tanggal) {
        continue; // skip jika tanggal kosong
        }
        $tanggalMasuk = \Carbon\Carbon::parse($tenant->tanggal);
        $bulanMasuk = (int) $tanggalMasuk->format('m');
        $tahunMasuk = (int) $tanggalMasuk->format('Y');

         // Lewati tenant yang belum masuk
        if (
            $tahunMasuk > (int)$tahun ||
            ($tahunMasuk == (int)$tahun && $bulanMasuk > (int)$bulan)
        ) {
            continue;
        }
        // Cek apakah tagihan sudah ada
        $existingBill = Bill::where('tenant_id', $tenant->id)
                            ->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            ->first();

        if (!$existingBill) {
            // Buat tagihan otomatis
            Bill::create([
                'tenant_id' => $tenant->id,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'jumlah' => $tenant->harga,
                'status' => 'belum_lunas',
            ]);
        }
    }

    // Ambil semua tagihan setelah proses di atas
    // $bills = Bill::whereHas('tenant', function($query) use ($propertyId) {
    //     $query->where('property_id', $propertyId);
    // })
    $bills = Bill::whereHas('tenant', function($query) use ($propertyId, $bulan, $tahun) {
        $query->where('property_id', $propertyId)
          ->whereDate('tanggal', '<=', "$tahun-$bulan-01");
    })
    ->with('tenant.room')
    ->where('bulan', $bulan)
    ->where('tahun', $tahun)
    ->get();

    return view('dashboard.dashboard-tagihan', compact('bills', 'bulan', 'tahun', 'property', 'propertyId'));
}


public function updateStatus(Request $request, Bill $bill)
{
    $request->validate([
        'status' => 'required|in:lunas,belum lunas',
    ]);

    $bill->status = $request->status;
    $bill->save();

    return back()->with('success', 'Status tagihan berhasil diperbarui.');
}


}
