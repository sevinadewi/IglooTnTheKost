<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;

class AdminController extends Controller
{
    public function index()
    {
         $userCount = User::count();
        $propertyCount = Property::count();
        $adminCount = User::where('role', 'admin')->count();

        return view('admin.dashboard', compact('userCount', 'propertyCount', 'adminCount'));
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

        return redirect()->route('admin.edit-user-role')->with('success', 'Role updated!');
    }

    public function editUserProperties($user_id)
    {
        $user = User::with('properties')->findOrFail($user_id);

        $allProperties = Property::all();

        return view('admin.edit-user-properties', compact('user', 'allProperties'));
    }

    public function updateUserProperties(Request $request, $user_id)
    {
        $user = User::with('properties')->findOrFail($user_id);
        $propertyIds = $request->input('properties', []);
        $user->properties()->sync($propertyIds);

        return redirect()->route('admin.dashboard')->with('success', 'User property access updated');
    }

    public function editUserRole()
    {
    $users = User::all();
    $properties = Property::all();

    return view('admin.edit-user-role', compact('users', 'properties'));
    }


}
