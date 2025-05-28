<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h2>Daftar Properti</h2>
        <div class="row">
            @foreach ($properties as $property)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="{{ asset($property->foto) }}" class="card-img-top" alt="Foto Properti">
                        <div class="card-body">
                            <h5 class="card-title">{{ $property->nama }}</h5>
                            <p class="card-text">{{ $property->alamat }}</p>
                            <p class="card-text"><small class="text-muted">{{ $property->kota_kabupaten }}, {{ $property->provinsi }}</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>