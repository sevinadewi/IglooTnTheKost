@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="{{asset ('assets/css/dashboard-tagihan.css')}}">
@endsection

@section('content')
  <div class="tagihan-main">
     <div class="top-bar p-3">
      <button class="btn-add" id="addRoomBtn">
        <i class='bx bx-edit-alt'></i> Buat Tagihan
      </button>
    </div>

    <!-- Card form default -->
    <div class="card shadow-sm mt-3 mx-4 w-100" id="tagihanCardDefault">
      <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <h5 class="mb-0" style="color: rgb(17, 16, 16);"><i class='bx bx-edit'></i> Lihat Tagihan</h5>
      </div>
      <div class="card-body" id="formSectionDefault">
        <form id="formBulanTahunDefault">
          <div class="mb-3">
            <label for="bulanDefault" class="form-label">Bulan</label>
            <select id="bulanDefault" class="form-select" required>
              <option value="" selected>-- Pilih Bulan --</option>
              <option value="01">Januari</option>
              <option value="02">Februari</option>
              <option value="03">Maret</option>
              <option value="04">April</option>
              <option value="05">Mei</option>
              <option value="06">Juni</option>
              <option value="07">Juli</option>
              <option value="08">Agustus</option>
              <option value="09">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desember</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="tahunDefault" class="form-label">Tahun</label>
            <select id="tahunDefault" class="form-select" required>
              <option value="" selected>-- Pilih Tahun --</option>
              <option value="2024">2024</option>
              <option value="2025">2025</option>
              <option value="2026">2026</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary btn-submit">Lihat Tagihan</button>
        </form>

        <!-- Tempat untuk render hasil tagihan -->
        <div id="hasilTagihan" class="mt-4"></div>
      </div>
    </div>

    <!-- Card Buat Tagihan -->
<div class="card shadow-sm mt-3 mx-4 w-100" id="tagihanCard" style="display: none; width: 100%;">
  <div class="card-header d-flex justify-content-between align-items-center bg-white">
    <h5 class="mb-0" style="color: rgb(17, 16, 16);"><i class='bx bx-edit'></i> Buat Tagihan</h5>
    <div>
      <button class="btn btn-sm text-secondary" onclick="minimizeCard()">&#8211;</button>
      <button class="btn btn-sm text-danger" onclick="closeCard()">&#10006;</button>
    </div>
  </div>
  <div class="card-body" id="formSection">
    <form id="formBuatTagihan">
      <div class="mb-3">
        <label for="penghuniId" class="form-label">ID Penghuni</label>
        <select id="penghuniId" class="form-select" required>
          <option value="">-- Pilih Penghuni --</option>
          <option value="P001">P001 - Ani</option>
          <option value="P002">P002 - Budi</option>
          <!-- Tambah opsi lainnya sesuai kebutuhan -->
        </select>
      </div>
      <div class="mb-3">
        <label for="bulan" class="form-label">Bulan</label>
        <select id="bulan" class="form-select" required>
          <option value="">-- Pilih Bulan --</option>
          <option value="01">Januari</option>
          <option value="02">Februari</option>
          <option value="03">Maret</option>
          <option value="04">April</option>
          <option value="05">Mei</option>
          <option value="06">Juni</option>
          <option value="07">Juli</option>
          <option value="08">Agustus</option>
          <option value="09">September</option>
          <option value="10">Oktober</option>
          <option value="11">November</option>
          <option value="12">Desember</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="tahun" class="form-label">Tahun</label>
        <select id="tahun" class="form-select" required>
          <option value="">-- Pilih Tahun --</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
          <option value="2026">2026</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah Tagihan</label>
        <input type="number" class="form-control" id="jumlah" placeholder="Masukkan jumlah (Rp)" required />
      </div>
      <button type="submit" class="btn btn-primary btn-submit">Tambah Tagihan</button>
    </form>
  </div>
</div>

  </div>
     
     <!-- Script untuk menampilkan data -->
  <script>
    document.getElementById('addRoomBtn').addEventListener('click', function () {
    document.getElementById('tagihanCard').style.display = 'block';
    document.getElementById('tagihanCardDefault').style.display = 'none';
    document.getElementById('tagihanCard').scrollIntoView({ behavior: 'smooth' });
  });

  function minimizeCard() {
    const formSection = document.getElementById('formSection');
    formSection.style.display = formSection.style.display === 'none' ? 'block' : 'none';
  }

  function closeCard() {
    document.getElementById('tagihanCard').style.display = 'none';
    document.getElementById('tagihanCardDefault').style.display = 'block';
  }

  // Handle form default: munculkan tabel tagihan di bawahnya
  document.getElementById('formBulanTahunDefault').addEventListener('submit', function (e) {
    e.preventDefault();
    const bulan = document.getElementById('bulanDefault').value;
    const tahun = document.getElementById('tahunDefault').value;
    if (!bulan || !tahun) {
      alert('Mohon pilih bulan dan tahun');
      return;
    }

    const dataTagihan = [
      { id: 'P001', nama: 'Ani', tagihan: 'Rp200.000', status: 'Belum Lunas' },
      { id: 'P002', nama: 'Budi', tagihan: 'Rp150.000', status: 'Lunas' }
    ];

    const html = `
      <table class="table table-bordered">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>ID Penghuni</th>
            <th>Nama</th>
            <th>Tagihan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          ${
            dataTagihan.length > 0
              ? dataTagihan.map((d, i) => `
                <tr>
                  <td>${i + 1}</td>
                  <td>${d.id}</td>
                  <td>${d.nama}</td>
                  <td>${d.tagihan}</td>
                  <td>${d.status}</td>
                </tr>
              `).join('')
              : `<tr><td colspan="5" class="text-center">Tidak ada data tagihan untuk bulan & tahun ini.</td></tr>`
          }
        </tbody>
      </table>
    `;

    document.getElementById('hasilTagihan').innerHTML = html;
  });

  // Form kedua redirect ke halaman
  document.getElementById('formBulanTahun').addEventListener('submit', function (e) {
    e.preventDefault();
    const bulan = document.getElementById('bulan').value;
    const tahun = document.getElementById('tahun').value;
    if (!bulan || !tahun) {
      alert('Mohon pilih bulan dan tahun');
      return;
    }
    window.location.href = `datatagihan.html?bulan=${bulan}&tahun=${tahun}`;
  });

  // Tangani submit form Buat Tagihan manual
  document.getElementById('formBuatTagihan').addEventListener('submit', function (e) {
  e.preventDefault();

  const id = document.getElementById('penghuniId').value;
  const bulan = document.getElementById('bulan').value;
  const tahun = document.getElementById('tahun').value;
  const jumlah = document.getElementById('jumlah').value;

  if (!id || !bulan || !tahun || !jumlah) {
    alert('Mohon lengkapi semua data.');
    return;
  }

  const nama = id === 'P001' ? 'Ani' : id === 'P002' ? 'Budi' : 'Tidak Diketahui';
  const jumlahFormatted = `Rp${parseInt(jumlah).toLocaleString('id-ID')}`;

  // Cek apakah tabel sudah ada
  let table = document.querySelector('#hasilTagihan table');
  let tbody;

  if (table) {
    tbody = table.querySelector('tbody');
  } else {
    // Buat tabel baru kalau belum ada
    const newTableHTML = `
      <table class="table table-bordered">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>ID Penghuni</th>
            <th>Nama</th>
            <th>Tagihan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    `;
    document.getElementById('hasilTagihan').innerHTML = newTableHTML;
    table = document.querySelector('#hasilTagihan table');
    tbody = table.querySelector('tbody');
  }

  const newRow = document.createElement('tr');
  const nomor = tbody.children.length + 1;
  newRow.innerHTML = `
    <td>${nomor}</td>
    <td>${id}</td>
    <td>${nama}</td>
    <td>${jumlahFormatted}</td>
    <td>Belum Lunas</td>
  `;
  tbody.appendChild(newRow);

  // Tutup card & reset form
  closeCard();
  document.getElementById('formBuatTagihan').reset();
});

  </script>

  <!-- Collapse Sidebar Script -->
  <script>
    document.querySelector('[data-resize-btn]').addEventListener('click', function(e) {
      e.preventDefault();
      document.body.classList.toggle('sb-collapsed');
    });
  </script>
@endsection