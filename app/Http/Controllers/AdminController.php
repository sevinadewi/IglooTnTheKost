<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        $properties = Property::all();

        return view('admin.dashboard', compact('users', 'properties'));
    }

    public function assignProperty(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
        ]);

        $user = User::find($request->user_id);
        $user->properties()->syncWithoutDetaching([$request->property_id]);

        return redirect()->route('admin.dashboard')->with('success', 'Property assigned!');
    }

    public function updateRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:user,admin',
        ]);

        $user = User::find($request->user_id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Role updated!');
    }

    public function editUserProperties($user_id)
    {
        $user = User::with('properties')->findOrFail($user_id);

        // $allProperties = Property::all();
        // Ambil semua properti yang belum diassign ke siapapun ATAU yang sudah dimiliki user ini
        // $allProperties = Property::whereDoesntHave('users', function ($query) use ($user_id) {
        //     $query->where('user_id', '!=', $user_id);
        // })->orWhereHas('users', function ($query) use ($user_id) {
        //     $query->where('user_id', $user_id);
        // })->get();
        $allProperties = Property::all();


        return view('admin.edit-user-properties', compact('user', 'allProperties'));
    }

    public function updateUserProperties(Request $request, $user_id)
    {
    //     $user = User::with('properties')->findOrFail($user_id);

    //     $propertyIds = $request->input('properties', []);

    //     // Cek apakah ada properti yang sudah dimiliki user lain
    // $conflictProperties = Property::whereIn('id', $propertyIds)
    //     ->whereHas('users', function ($q) use ($user_id) {
    //         $q->where('user_id', '!=', $user_id);
    //     })->pluck('nama')->toArray();

    // if (count($conflictProperties) > 0) {
    //     return back()->with('error', 'Properti berikut sudah dimiliki user lain: ' . implode(', ', $conflictProperties));
    // }


    //     $user->properties()->sync($propertyIds); // update akses properti
    //     return redirect()->route('admin.dashboard')->with('success', 'User property access updated');
     $user = User::with('properties')->findOrFail($user_id);
    $propertyIds = $request->input('properties', []);
    $user->properties()->sync($propertyIds);

    return redirect()->route('admin.dashboard')->with('success', 'User property access updated');
    }


}
