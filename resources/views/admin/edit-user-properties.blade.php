@extends('layout.admin-master')

@section('content')
<div class="edit-access-container">
    <h3>Kelola Akses Properti untuk: {{ $user->name }}</h3>
    


    <form action="{{ route('admin.updateUserProperties', $user->id) }}" method="POST">
        @csrf
        <ul>
            @foreach ($allProperties as $property)
            <li>
                <label>
                    <input type="checkbox" name="properties[]" value="{{ $property->id }}"
                        {{ $user->properties->contains($property->id) ? 'checked' : '' }}>
                    {{ $property->nama }}
                </label>
            </li>
            @endforeach
        </ul>

        <button type="submit">Simpan Akses</button>
    </form>
</div>
@endsection
