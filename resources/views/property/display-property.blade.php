<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="{{asset ('assets/css/property.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/css/style.css')}}"> --}}
    <style>

        body {
            background-color: #fff9db;
            font-family: Arial, sans-serif;
        }

        .cards-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 40px 20px;
        box-sizing: border-box;
        
    }

        .cards-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
        justify-content: center;
        }

        .card, .card-plus {
        width: 250px;
        height: 300px;
        background: #fcfbf8;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        padding: 10px;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: start;
        }

        .card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 8px;
        background-color: #FFF8E7;
        }


        .card h4 {
        margin: 10px 0 0;
        }

        .card a {
            text-decoration: none;
            color: inherit; /* supaya warnanya tetap seperti teks biasa */
        }

        .card p {
        margin: 5px 0 0;
        }

        .card h4 {
            color: goldenrod;
            margin: 10px 0 0;
            font-size: 24px;
            font-weight: bold;
        }

        .card-plus {
        border: 2px dashed gold;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 48px;
        color: gold;
        }

        .card:hover {
            background-color: #fffbea;
            transition: 0.3s;
        }

        .edit-btn {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgb(84, 88, 105);
        color: white;
        border: none;
        border-radius: 4px;
        padding: 4px 8px;
        cursor: pointer;
        font-size: 12px;
        }

        /* Modal */
        .modal {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
        }

        .modal.show {
        display: flex;
        }

        .modal-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        }

        .modal-content input {
        width: 100%;
        margin-bottom: 10px;
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
        }

        .form-buttons {
        display: flex;
        justify-content: space-between;
        }

        .btn-save, .btn-cancel {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }

        .btn-save { background: green; color: white; }
        .btn-cancel { background: red; color: white; }
    </style>
</head>
<body>
    <div class="container">
        {{-- <h2>Daftar Properti</h2> --}}
        <div class="row">

        <div class="cards-wrapper" id="cardsWrapper">
            <!-- Contoh card properti -->
            @foreach ($properties as $property)
            <div class="card">
                <a href="{{ route('property.dashboard', $property->id) }}" class="card-link" >
                <img src="{{ asset($property->foto) }}" alt="Properti" >
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