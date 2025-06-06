<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="{{asset ('assets/css/property.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/css/style.css')}}">
    {{-- <style>
        .card-link {
            text-decoration: none;
            color: inherit;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transform: translateY(-5px);
            transition: 0.3s;
        }
    </style> --}}
</head>
<body>
    <div class="container">
        <h2>Daftar Properti</h2>
        <div class="row">
            
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

                 {{-- <div class="col-md-4 mb-3">
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
                </div> --}}

        <div class="cards-wrapper" id="cardsWrapper">
            <!-- Contoh card properti -->
            @foreach ($properties as $property)
            <div class="card">
                <a href="{{ route('property.dashboard', $property->id) }}" class="card-link" >
                <img src="{{ asset($property->foto) }}" alt="Properti" style="height: 50px; object-fit: cover; width: 100%;">
                <h4>{{ $property->nama }}</h4>
                <p>{{ $property->alamat }}</p>
                </a>
            </div>
            @endforeach
            <!-- Card plus -->
            <div class="card-plus" id="addCardBtn">
                <span style="font-size: 48px; display: block; text-align: center;">+</span>
            </div>
        </div>

        <div class="modal" id="propertyModal">
            <div class="modal-content">
                <h3>Tambah Properti Baru</h3>
                <input type="text" id="propertyName" placeholder="Nama Properti">
                <input type="text" id="propertyAddress" placeholder="Alamat Properti">
                <input type="text" id="propertyImage" placeholder="Link Gambar">
                <div class="form-buttons">
                <button class="btn-save" id="saveProperty">Simpan</button>
                <button class="btn-cancel" id="cancelProperty">Batal</button>
                </div>
            </div>
        </div>
            
        </div>
    </div>

    <script>
        const modal = document.getElementById("propertyModal");
        const addBtn = document.getElementById("addCardBtn");
        const cancelBtn = document.getElementById("cancelProperty");
        const nameInput = document.getElementById("propertyName");
        const addressInput = document.getElementById("propertyAddress");
        const imageInput = document.getElementById("propertyImage");


        addBtn.addEventListener("click", () => {
            modal.style.display = "flex";
        });
        cancelBtn.addEventListener("click", () => {
        modal.style.display = "none";
        nameInput.value = "";
        addressInput.value = "";
        imageInput.value = "";
        });

        
    </script>
</body>
</html>