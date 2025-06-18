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
    $bills = Bill::whereHas('tenant', function($query) use ($propertyId) {
        $query->where('property_id', $propertyId);
    })
    ->with('tenant.room')
    ->where('bulan', $bulan)
    ->where('tahun', $tahun)
    ->get();

    return view('dashboard.dashboard-tagihan', compact('bills', 'bulan', 'tahun', 'property', 'propertyId'));
}

}
