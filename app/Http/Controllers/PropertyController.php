<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
class PropertyController extends Controller
{
    public function index()
    {
        // return view('property.index');
        $currentStep = session('currentStep', 1); // default 1 kalau belum ada
        return view('property.index', compact('currentStep'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'properti' => 'required|string',
            'alamat' => 'required|string',
            'kodePos' => 'required|string',
            'provinsi' => 'required|string',
            'kotaKab' => 'required|string',
            'kec' => 'required|string',
            'kel' => 'required|string',
            'no_wa' => 'nullable|string',
        ]);

        Property::create([
            'nama' => $validated['properti'],
            'alamat' => $validated['alamat'],
            'kode_pos' => $validated['kodePos'],
            'provinsi' => $validated['provinsi'],
            'kota_kabupaten' => $validated['kotaKab'],
            'kecamatan' => $validated['kec'],
            'kelurahan' => $validated['kel'],
            'no_wa' => $validated['no_wa'],
        ]);

        // ⬇️ Tambahkan baris ini untuk menyimpan step ke sesi
        session(['currentStep' => 2]);

        return redirect()->route('property.index')->with('success', 'Properti berhasil ditambahkan.');
    }
}
