@extends('layout.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard-tagihan.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<style>
 .btn-preview {
    display: inline-flex;
    align-items: center;
    gap: 5px; /* jarak antara icon dan teks */
    background-color: #EBC005;
    border: none;
    color: #fff;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: bold;
}

.btn-preview:hover {
    background-color: #d1a904;
}

.btn-preview i {
    font-size: 18px;
}

</style>
@endsection

@section('content')
<div class="tagihan-main">
  <button class="toggle-sidebar" onclick="toggleSidebar()">
    <i class="bx bx-menu"></i>
  </button>

  <div class="top-bar p-3">
    <div class="alert alert-info mx-4 mt-3" style="margin-bottom: 8px;">
      <i class='bx bx-info-circle'></i>
      Tagihan otomatis telah dijadwalkan dan akan dikirim ke penyewa setiap bulan sesuai tanggal jatuh tempo.
    </div>
    <button class="btn-preview" onclick="showTagihanPreview()">
      <i class='bx bx-show'></i> Preview Tagihan
    </button>
  </div>

  <div id="tagihanPreviewModal" class="my-modal">
  <div class="my-modal-content">
    <span class="close" onclick="closeTagihanPreview()">&times;</span>
    <img src="{{ asset('assets/img/tagihan-preview.png') }}" alt="Preview Tagihan" style="max-width: 100%; border-radius: 8px;">
  </div>
</div>


  <div class="card shadow-sm mt-3 mx-4 w-100" id="tagihanCardDefault">
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
      <h5 class="mb-0" style="color: rgb(17, 16, 16);"><i class='bx bx-edit'></i> Lihat Tagihan</h5>
    </div>

    <div class="card-body" id="formSectionDefault">
      <form id="formBulanTahunDefault" method="GET" action="{{ route('dashboard-tagihan', ['propertyId' => $property->id]) }}">
        <div class="mb-3">
          <label for="bulanDefault" class="form-label">Bulan</label>
          <select id="bulanDefault" name="bulan" class="form-select" required>
            <option value="">-- Pilih Bulan --</option>
            @foreach (range(1,12) as $b)
              <option value="{{ str_pad($b,2,'0',STR_PAD_LEFT) }}" {{ request('bulan') == str_pad($b,2,'0',STR_PAD_LEFT) ? 'selected' : '' }}>
                {{ DateTime::createFromFormat('!m', $b)->format('F') }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="tahunDefault" class="form-label">Tahun</label>
          <select id="tahunDefault" name="tahun" class="form-select" required>
            <option value="">-- Pilih Tahun --</option>
            @for ($y = 2023; $y <= now()->year + 2; $y++)
              <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
          </select>
        </div>

        <button type="submit" class="btn-add">Lihat Tagihan</button>
      </form>

      <div id="hasilTagihan" class="mt-4"></div>
    </div>
  </div>
</div>

@if(request('bulan') && request('tahun') && isset($bills) && count($bills) > 0)
<!-- Modal Tabel -->
<div class="modal fade" id="tableModal" tabindex="-1" aria-labelledby="tableModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tableModalLabel">Tabel Tagihan Lengkap</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama Penyewa</th>
              <th>Bulan</th>
              <th>Tahun</th>
              <th>Jumlah</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($bills as $index => $bill)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $bill->tenant->nama ?? '-' }}</td>
              <td>{{ DateTime::createFromFormat('!m', $bill->bulan)->format('F') }}</td>
              <td>{{ $bill->tahun }}</td>
              <td>Rp{{ number_format($bill->jumlah, 0, ',', '.') }}</td>
              <td>
                <form method="POST" action="{{ route('bills.updateStatus', $bill->id) }}">
                  @csrf
                  @method('PATCH')
                  <select name="status" class="form-select form-select-sm {{ $bill->status == 'lunas' ? 'text-success' : 'text-danger' }}" onchange="this.form.submit()">
                    <option value="belum lunas" {{ $bill->status == 'belum lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="lunas" {{ $bill->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                  </select>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif

@if(request('bulan') && request('tahun') && isset($bills) && count($bills) === 0)
<div class="alert alert-warning mx-4 mt-4">Tidak ada data tagihan untuk bulan dan tahun ini.</div>
@endif
@endsection


@push('scripts')
<!-- Bootstrap JS dari CDN (tanpa integrity kalau belum punya hash valid) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Form validasi sebelum submit
    const form = document.getElementById('formBulanTahunDefault');
    if (form) {
      form.addEventListener('submit', function (e) {
        const bulan = document.getElementById('bulanDefault').value;
        const tahun = document.getElementById('tahunDefault').value;
        if (!bulan || !tahun) {
          e.preventDefault();
          alert('Mohon pilih bulan dan tahun terlebih dahulu.');
        }
      });
    }

    // Auto show modal jika ada data
    @if(request('bulan') && request('tahun') && isset($bills) && count($bills) > 0)
      const tableModal = document.getElementById('tableModal');
      if (tableModal) {
        console.log("🚀 Modal ditemukan, akan ditampilkan.");
        const modal = new bootstrap.Modal(tableModal);
        modal.show();
      } else {
        console.warn("❌ tableModal tidak ditemukan!");
      }
    @endif
  });

  // Toggle sidebar
  function toggleSidebar() {
    document.body.classList.toggle('sb-open');
  }
</script>
<script>
function showTagihanPreview() {
    document.getElementById('tagihanPreviewModal').classList.add('active');
}

function closeTagihanPreview() {
    document.getElementById('tagihanPreviewModal').classList.remove('active');
}

// Tutup modal kalau klik di luar kontennya
window.onclick = function(event) {
  var modal = document.getElementById('tagihanPreviewModal');
  if (event.target == modal) {
    modal.classList.remove('active');
  }
}

</script>

@endpush
