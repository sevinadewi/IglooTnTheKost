<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="assets/css/style.css">
    {{-- <link rel="stylesheet" href="{{asset ('assets/css/property.css')}}"> --}}
    {{-- <link rel="stylesheet" href="{{asset ('assets/css/style.css')}}">  --}}
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


 /* MODAL */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* backdrop gelap */
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal.show {
    display: flex;
    padding-right: 1rem; /* menghindari loncatan scrollbar */
}

.modal-content {
    background-color: #fff; /* sama seperti .card */
    padding: 1.25rem;
    border-radius: 0.75rem; /* sama seperti .card-person */
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-sizing: border-box;
    box-shadow: 0 0 10px rgba(0,0,0,0.1); /* serasi dengan .card */
    scrollbar-gutter: stable;
    font-family: Arial, sans-serif;
}

/* SCROLLBAR custom agar konsisten */
.modal-content::-webkit-scrollbar {
    width: 8px;
}

.modal-content::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 4px;
}

/* FORM DALAM MODAL */
.modal-content form {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.modal-content input,
.modal-content select,
.modal-content textarea {
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    box-sizing: border-box;
}

.form-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
}

.btn-save,
.btn-cancel {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-weight: bold;
    cursor: pointer;
}

.btn-save {
    background-color: #000;
    color: #fff;
}

.btn-cancel {
    background-color: #EBC005;
    border: 1px solid #000;
    color: #000;
}



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


        <div id="propertyModal" class="modal" role="dialog" aria-modal="true">
            <div class="modal-content">
                <form action="{{ route('property.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <h3 id="formTitle">Tambah properti baru</h3>
                    {{-- <input type="hidden" id="editingIndex"> --}}
                    <div class="form-group">
                        <label for="properti">Nama Properti</label>
                        <input type="text" id="properti" name="properti" placeholder="Nama Properti *" value="{{ old('properti') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat" placeholder="Alamat *" value="{{ old('alamat') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kodePos">Kode Pos</label>
                        <input type="text" id="kodePos" name="kodePos" placeholder="Kode pos *" value="{{ old('kodePos') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <input type="text" id="provinsi" name="provinsi" placeholder="Provinsi *" value="{{ old('provinsi') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kotaKab">Kota/Kabupaten</label>
                        <input type="text" id="kotaKab" name="kotaKab" placeholder="Kota/Kabupaten *" value="{{ old('kotaKab') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kec">Kecamatan</label>
                        <input type="text" id="kec" name="kec" placeholder="Kecamatan *" value="{{ old('kec') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kel">Kelurahan</label>
                        <input type="text" id="kel" name="kel" placeholder="Kelurahan *" value="{{ old('kel') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor">Whatsapp Admin Properti</label>
                        <input type="text" id="nomor" name="no_wa" placeholder="Whatsapp Admin Properti" value="{{ old('no_wa') }}">
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto Kos</label>
                        <input type="file" id="foto" name="foto"  accept="image/*">
                    </div>
                    <input type="hidden" name="redirect_to" value="display">
                    <div class="form-buttons">
                        <button type="submit" class="btn-save">Simpan</button>
                        <button type="button" onclick="hideForm('propertyModal')" class="btn-cancel">Batal</button>
                    </div>
                </form>
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
        function hideForm(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
  }
}



        
    </script>
</body>
</html>