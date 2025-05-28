<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $currentStep = session('currentStep', 1);
        $propertyId = session('property_id');

        $rooms = Room::with('property')
        ->where('property_id', $propertyId)
        ->get();
        $tenants = Tenant::with('room')->get();

        return view('property.index', compact('currentStep', 'rooms', 'tenants'));
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = null;

        if($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('public/foto_property');
            $fotoPath = str_replace('public/','storage/', $fotoPath);
        } else {
            $fotoPath = 'assets/img/default-property.png';
        }

        $property = Property::create([
            'nama' => $validated['properti'],
            'alamat' => $validated['alamat'],
            'kode_pos' => $validated['kodePos'],
            'provinsi' => $validated['provinsi'],
            'kota_kabupaten' => $validated['kotaKab'],
            'kecamatan' => $validated['kec'],
            'kelurahan' => $validated['kel'],
            'no_wa' => $validated['no_wa'],
            'foto' => $fotoPath,
            'user_id' => Auth::id(),
        ]);

        session(['currentStep' => 2]);
        session(['property_id' => $property->id]);

        return redirect()->route('property.index')->with('success', 'Properti berhasil ditambahkan.');
    }

    public function storeRoom(Request $request)
    {
        $validated = $request->validate([
            'nama_kamar' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        $propertyId = session('property_id');

        Room::create([
            'property_id' => $propertyId,
            'nama' => $validated['nama_kamar'],
            'harga' => $validated['harga'],
        ]);

        session(['currentStep' => 3]);

        return redirect()->route('property.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function storeTenant(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'nama_penyewa' => 'required|string',
            'no_hp' => 'nullable|string',
        ]);

        Tenant::create([
            'room_id' => $validated['room_id'],
            'nama' => $validated['nama_penyewa'],
            'no_hp' => $validated['no_hp'],
        ]);

        session(['currentStep' => 1]);
        session()->forget('property_id');

        return redirect()->route('property.display-property')->with('success', 'Penyewa berhasil ditambahkan.');
    }

    // Opsional: reset atau navigasi manual
    public function resetStep()
    {
        session(['currentStep' => 1]);
        session()->forget('property_id');

        return redirect()->route('property.index');
    }

    public function showProperty()
    {
        $userId = Auth::id();
        $properties = Property::where('user_id', $userId)->get();
        return view('property.display-property', compact('properties'));
    }

    
}
