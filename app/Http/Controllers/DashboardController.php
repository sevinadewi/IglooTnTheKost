<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show($id)
    {
        $property = Property::findOrFail($id);
        return view('dashboard.dashboard-index', compact('property'));
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
