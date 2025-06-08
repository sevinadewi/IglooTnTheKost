@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="{{asset ('assets/css/dashboard-tagihan.css')}}">
@endsection

@section('content')
  <div class="tagihan-main">
    <div class="header-info mb-3">
      📌 Data Tagihan<br />
      <span id="bulanTahun">Bulan: -, Tahun: -</span>
    </div>

    <!-- Tombol Kembali -->
    <button type="button" class="btn btn-secondary mb-3" onclick="window.history.back();">
      &larr; Kembali
    </button>

    <div class="card shadow-sm">
      <div class="card-body p-0">
        <table class="table table-striped table-bordered mb-0">
          <thead class="table-primary">
            <tr>
              <th style="width: 5%;">No</th>
              <th style="width: 15%;">ID Penghuni</th>
              <th>Nama</th>
              <th style="width: 20%;">Tagihan</th>
              <th style="width: 15%;">Status</th>
            </tr>
          </thead>
          <tbody id="tbodyTagihan">
            <tr><td colspan="5" class="text-center">Memuat data...</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
     
     <!-- Script untuk menampilkan data -->
  <script>
    const bulanNames = {
      "01": "Januari", "02": "Februari", "03": "Maret", "04": "April",
      "05": "Mei", "06": "Juni", "07": "Juli", "08": "Agustus",
      "09": "September", "10": "Oktober", "11": "November", "12": "Desember"
    };

    const urlParams = new URLSearchParams(window.location.search);
    const bulan = urlParams.get('bulan');
    const tahun = urlParams.get('tahun');

    const bulanTahunEl = document.getElementById('bulanTahun');
    if (bulan && tahun && bulanNames[bulan]) {
      bulanTahunEl.textContent = `Bulan: ${bulanNames[bulan]}, Tahun: ${tahun}`;
    } else {
      bulanTahunEl.textContent = `Bulan: -, Tahun: -`;
    }

    const tbody = document.getElementById('tbodyTagihan');
    const dataTagihanArray = JSON.parse(localStorage.getItem('dataTagihanArray')) || [];

    const dataFiltered = dataTagihanArray.filter(item => item.bulan === bulan && item.tahun === tahun);

    if (dataFiltered.length === 0) {
      tbody.innerHTML = `<tr><td colspan="5" class="text-center">Tidak ada data tagihan untuk bulan & tahun ini.</td></tr>`;
    } else {
      tbody.innerHTML = dataFiltered.map((item, index) => {
        const statusClass = item.statusBayar.toLowerCase() === "sudah bayar" ? "status-sudah-bayar" : "status-belum-bayar";
        return `
          <tr>
            <td>${index + 1}</td>
            <td>${item.idPenghuni}</td>
            <td>${item.namaPenghuni}</td>
            <td>Rp ${Number(item.tagihan).toLocaleString('id-ID')}</td>
            <td class="${statusClass}">${item.statusBayar}</td>
          </tr>
        `;
      }).join('');
    }
  </script>

  <!-- Collapse Sidebar Script -->
  <script>
    document.querySelector('[data-resize-btn]').addEventListener('click', function(e) {
      e.preventDefault();
      document.body.classList.toggle('sb-collapsed');
    });
  </script>
@endsection