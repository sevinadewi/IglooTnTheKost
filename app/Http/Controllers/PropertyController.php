<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
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

        // Tentukan redirect berdasarkan input
        if ($request->redirect_to === 'display') {
            return redirect()->route('property.display-property', ['id' => $property->id])
                            ->with('success', 'Properti berhasil ditambahkan.');
        }
        return redirect()->route('property.index')->with('success', 'Properti berhasil ditambahkan.');
    }

    public function storeRoom(Request $request)
    {
             // Ubah string fasilitas jadi array (trim tiap elemen)
    $fasilitasArray = array_map('trim', explode(',', $request->input('fasilitas')));

    // Ganti input fasilitas jadi array supaya validasi array bisa jalan
    $request->merge(['fasilitas' => $fasilitasArray]);
    
        Log::info('Room store request:', $request->all());
    

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'nama' => 'required|string|max:255',
            'fasilitas' => 'required|array',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'harga' => 'required|integer',
            'status' => 'required|string',
        ]);

        // Simpan gambar ke storage publik
        $gambarPath = $request->file('gambar')->store('gambar_kamar', 'public');

        // Simpan data kamar ke DB
        Room::create([
            'property_id' => $request->property_id,
            'nama' => $request->nama,
            'fasilitas' => $request->fasilitas, // array akan otomatis diserialisasi ke JSON
            'gambar' => $gambarPath,
            'harga' => $request->harga,
            'status' => $request->status,
        ]);

        // Set session currentStep agar step 3 aktif saat reload halaman
        session(['currentStep' => 3]);

        return redirect()->route('property.index')->with('success', 'Kamar berhasil ditambahkan');
    }

    public function storeTenant(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'tanggal' => 'required|date',
            'email' => 'nullable|email',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $room = Room::findOrFail($request->room_id);

        Tenant::create([
            
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'tanggal' => $request->tanggal,
            'email' => $request->email,
            'room_id' => $room->id,
            'property_id' => $room->property_id,
            'harga' => $room->harga,
            'status' => 'aktif'
        ]);

        $room->update(['status' => 'terisi']);


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
