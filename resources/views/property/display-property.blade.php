<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-link {
            text-decoration: none;
            color: inherit;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transform: translateY(-5px);
            transition: 0.3s;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Properti</h2>
        <div class="row">
            @foreach ($properties as $property)
                {{-- <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="{{ asset($property->foto) }}" class="card-img-top" alt="Foto Properti">
                        <div class="card-body">
                            <h5 class="card-title">{{ $property->nama }}</h5>
                            <p class="card-text">{{ $property->alamat }}</p>
                            <p class="card-text"><small class="text-muted">{{ $property->kota_kabupaten }}, {{ $property->provinsi }}</small></p>
                        </div>
                    </div>
                </div> --}}

                 <div class="col-md-4 mb-3">
                    <a href="{{ route('property.dashboard', $property->id) }}" class="card-link">
                        <div class="card h-100">
                            <img src="{{ asset($property->foto) }}" class="card-img-top" alt="Foto Properti" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $property->nama }}</h5>
                                <p class="card-text">{{ $property->alamat }}</p>
                                <p class="card-text">
                                    <small class="text-muted">{{ $property->kotaKab }}, {{ $property->provinsi }}</small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>