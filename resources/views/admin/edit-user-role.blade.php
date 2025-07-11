@extends('layout.admin-master')

@section('content')

<div style="padding: 0 20px; width: 100%; margin: 20px;">
    {{-- <form action="{{ route('admin.assignProperty') }}" method="POST">
    @csrf
    <select name="user_id">
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <select name="property_id">
        @foreach ($properties as $property)
            <option value="{{ $property->id }}">{{ $property->name }}</option>
        @endforeach
    </select>

    <button type="submit">Assign Property</button>
</form> --}}



<h3>Daftar User</h3>
<div class="main-container">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.updateRole') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <select name="role" onchange="this.form.submit()">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </form>
                </td>
                <td>
                    <a href="{{ route('admin.editUserProperties', $user->id) }}" class="btn-all" style="text-decoration: none">Kelola Akses Properti</a>
                </td>
                <td>
                    <!-- Aksi lain seperti lihat properti yang dia kelola -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection