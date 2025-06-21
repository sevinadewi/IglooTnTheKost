@extends('layout.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{asset ('assets/css/dashboard-tagihan.css')}}">
@endsection

@section('content')
  <div class="tagihan-main">
     <div class="top-bar p-3">
      {{-- <button class="btn-add" id="addRoomBtn">
        <i class='bx bx-edit-alt'></i> Buat Tagihan
      </button> --}}
      <div class="alert alert-info mx-4 mt-3" style="margin-bottom: 8px;">
        <i class='bx bx-info-circle'></i>
        Tagihan otomatis telah dijadwalkan dan akan dikirim ke penyewa setiap bulan sesuai tanggal jatuh tempo.
    </div>
    </div>

    <!-- Card form default -->
    <div class="card shadow-sm mt-3 mx-4 w-100" id="tagihanCardDefault">
      <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <h5 class="mb-0" style="color: rgb(17, 16, 16);"><i class='bx bx-edit'></i> Lihat Tagihan</h5>
      </div>
      <div class="card-body" id="formSectionDefault">
        {{-- <form id="formBulanTahunDefault">
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
        </form> --}}
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

          <button type="submit" class="btn btn-primary btn-submit">Lihat Tagihan</button>
        </form>

        <!-- Tempat untuk render hasil tagihan -->
        <div id="hasilTagihan" class="mt-4"></div>
      </div>
    </div>

    @if(isset($bills) && count($bills) > 0)
    <div id="tabelTagihan" class="mx-4 mt-4" style="display: {{ (request('bulan') && request('tahun')) ? 'block' : 'none' }}">

      {{-- <div class="mt-4">
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
                <td>{{ ucfirst($bill->status) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> --}}
      <!-- Modal Tabel -->
    <div class="modal fade" id="tableModal" tabindex="-1" aria-labelledby="tableModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tableModalLabel">Tabel Tagihan Lengkap</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="scroll-wrapper">
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
                          <select name="status" class="form-select form-select-sm 
                            {{ $bill->status == 'lunas' ? 'text-success' : 'text-danger' }}" 
                            onchange="this.form.submit()">
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

         @elseif(request('bulan') && request('tahun'))
      <div class="alert alert-warning mt-4">Tidak ada data tagihan untuk bulan dan tahun ini.</div>
    @endif
        </div>
      </div>
      
    </div>

    </div>
   


  
  </div>
     @if(request('bulan') && request('tahun') && isset($bills) && count($bills) > 0)
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          var tableModal = new bootstrap.Modal(document.getElementById('tableModal'));
          tableModal.show();
        });
      </script>
    @endif

     <!-- Script untuk menampilkan data -->
     <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
     
      <script>
        document.getElementById('formBulanTahunDefault').addEventListener('submit', function (e) {
        const bulan = document.getElementById('bulanDefault').value;
        const tahun = document.getElementById('tahunDefault').value;

        if (!bulan || !tahun) {
          e.preventDefault();
          alert('Mohon pilih bulan dan tahun terlebih dahulu.');
        }
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