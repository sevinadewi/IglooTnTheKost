@extends('layout.master')

@section('styles')
    <style>
        /* 🔥 User Button */
.topbar {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 10px 20px;
}

.user-button {
    background: none;
    border: none;
    font-size: 32px;
    cursor: pointer;
    color: #333;
}

.user-button:hover {
    color: #fcd92c;
}

/* 🔥 User Dropdown */
.user-menu {
    position: relative;
}

.user-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 40px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    min-width: 160px;
    z-index: 999;
}

.user-dropdown a,
.user-dropdown button {
    display: block;
    width: 100%;
    padding: 10px 15px;
    color: #333;
    text-decoration: none;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
    font-size: 14px;
}

.user-dropdown a:hover,
.user-dropdown button:hover {
    background-color: #fcd92c;
    color: #000;
}

.user-dropdown.show {
    display: block;
}

/* 🔥 Page Title */
.page-title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 25px;
    color: #333;
    margin-left: 20px;
    
}

    </style>
@endsection
@section('content')
    <div class="main-content">
      {{-- <div class="topbar">
        <i class='bx bx-user-circle'></i>
      </div> --}}
      <div class="topbar">
        <div class="user-menu">
            <button class="user-button" onclick="toggleUserMenu()">
                <i class='bx bx-user-circle'></i>
            </button>
            <div class="user-dropdown" id="userDropdown">
                <a href="#">Edit Profil</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>

        </div>
    </div>


     
      <h2 class="page-title">Selamat Datang! Admin {{ $property->nama }}</h2>


      <div class="info-cards">
        <div class="card-container">
          <div class="column">
            <div class="card green">
              <div class="card-header">{{ $totalKamar }}</div>
              <div class="card-label">Total Kamar</div>
              <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>
            <div class="card yellow">
              <div class="card-label"><p></p>Total Pemasukan</div>
              <div class="card-header">35000000</div>
              <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>
            </div>
              <div class="card blue">
              <div class="card-header">{{ $penghuniAktif }}</div>
              <div class="card-label">Penghuni Aktif</div>
              <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>

            <div class="card red">
              <div class="card-header">{{ $penghuniNonAktif }}<small style="font-size: 12px;">/Bulan</small></div>
              <div class="card-label">Penghuni Non-Aktif</div>
              <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>
          </div>
        </div>
    

        {{-- <div style="margin-top: 40px;">
            <h4>📈 Jumlah Penghuni Aktif per Bulan</h4>
            <canvas id="penghuniBulananChart"></canvas>
        </div> --}}

        {{-- <div style="margin-top: 40px;">
            <h4>💰 Total Pemasukan Kos per Bulan</h4>
            <canvas id="pemasukanBulananChart"></canvas>
        </div> --}}

        


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- 🔥 Dropdown Script --}}
        <script>
            function toggleUserMenu() {
                const dropdown = document.getElementById('userDropdown');
                dropdown.classList.toggle('show');
            }

            window.onclick = function(event) {
                if (!event.target.matches('.user-button') && !event.target.closest('.user-menu')) {
                    const dropdown = document.getElementById('userDropdown');
                    if (dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                    }
                }
            };
        </script>
<script>
const bulanLabels = {!! json_encode($tenantsPerMonth->pluck('bulan')) !!};
const penghuniData = {!! json_encode($tenantsPerMonth->pluck('jumlah_penghuni')) !!};
const pemasukanData = {!! json_encode($tenantsPerMonth->pluck('total_pemasukan')) !!};

// Grafik penghuni per bulan
new Chart(document.getElementById('penghuniBulananChart'), {
    type: 'bar',
    data: {
        labels: bulanLabels,
        datasets: [{
            label: 'Jumlah Penghuni Aktif',
            data: penghuniData,
            backgroundColor: '#36A2EB'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 }
            }
        }
    }
});

// Grafik pemasukan per bulan
new Chart(document.getElementById('pemasukanBulananChart'), {
    type: 'line',
    data: {
        labels: bulanLabels,
        datasets: [{
            label: 'Total Pemasukan',
            data: pemasukanData,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: '#4BC0C0',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>


@endsection