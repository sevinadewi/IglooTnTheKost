@extends('layout.master')

@section('styles')
    <style>


    </style>
@endsection
@section('content')
    <div class="main-content">
        <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="bx bx-menu"></i>
            </button>
            <div class="top-bar-index">
                <h2 class="page-title">Selamat Datang! Admin {{ $property->nama }}</h2>
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
            </div>

<div style="padding: 0; margin: 20px; ">
      

    <div class="dashboard-grid" style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-start;">
    {{-- Kolom kiri: Kartu --}}
    <div class="info-cards" style="flex: 1 1 45%;">
        <div class="card-container">
            {{-- <div class="column"> --}}
                <div class="card green">
                    <div class="card-header">{{ $totalKamar }}</div>
                    <div class="card-label">Total Kamar</div>
                    <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
                </div>
                <div class="card yellow">
                    <div class="card-header" style="font-size: 30px; margin-bottom:10px;margin-top:10px">
                        Rp{{ number_format($tenantsPerMonth->sum('total_pemasukan'), 0, ',', '.') }}
                    </div>
                    <div class="card-label">Total Pemasukan</div>
                    <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
                </div>
            {{-- </div> --}}
            <div class="card blue">
                <div class="card-header">{{ $penghuniAktif }}</div>
                <div class="card-label">Penghuni Aktif</div>
                <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>
            <div class="card red">
                <div class="card-header">{{ $penghuniNonAktif }}</div>
                <div class="card-label">Penghuni Non-Aktif</div>
                <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>
        </div>
    </div>

    <div class="chart-section" style="flex: 1 1 50%;">
        <div class="chart-box">
            <div class="chart-wrapper">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        <div class="chart-box">
            <div class="chart-wrapper">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>
  
    </div>

</div>

</div>

</div>



        


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
    // Toggle sidebar di HP (responsive)
function toggleSidebar() {
    document.body.classList.toggle('sb-open');
}

// document.addEventListener("DOMContentLoaded", function () {
//     const bulanLabels = {!! json_encode($tenantsPerMonth->pluck('bulan')) !!};
//     const pemasukanData = {!! json_encode($tenantsPerMonth->pluck('total_pemasukan')) !!};

//     const commonOptions = {
//         responsive: true,
//         maintainAspectRatio: false,
//         plugins: {
//             legend: { display: false },
//             title: {
//                 display: true,
//                 text: '', // nanti diisi di tiap chart
//                 color: '#fff',   // judul putih
//                 font: { size: 16, weight: 'bold' },
//                 padding: { top: 10, bottom: 10 }
//             }
//         },
//         layout: {
//             padding: { left: 10, right: 10, top: 10, bottom: 10 }
//         },
//         scales: {
//             x: {
//                 ticks: { color: '#fff', font: { size: 12, weight: '500' } },
//                 grid: { display: false }
//             },
//             y: {
//                 ticks: {
//                     color: '#fff',
//                     font: { size: 12, weight: '500' },
//                     callback: value => 'Rp' + value.toLocaleString('id-ID')
//                 },
//                 grid: { color: 'rgba(255,255,255,0.2)', drawBorder: false }
//             }
//         }
//     };

//     const ctxLine = document.getElementById('lineChart').getContext('2d');

//     new Chart(ctxLine, {
//         type: 'line',
//         data: {
//             labels: bulanLabels,
//             datasets: [{
//                 label: 'Total Pemasukan',
//                 data: pemasukanData,
//                 borderColor: '#fff',            // garis putih
//                 backgroundColor: 'rgba(255,255,255,0.2)', // area bawah transparan putih
//                 pointBackgroundColor: '#fff',
//                 tension: 0.4,
//                 fill: true
//             }]
//         },
//         options: {
//             ...commonOptions,
//             plugins: {
//                 ...commonOptions.plugins,
//                 title: { ...commonOptions.plugins.title, text: 'Grafik Pemasukan (Line)' }
//             }
//         }
//     });

//     const ctxBar = document.getElementById('barChart').getContext('2d');
//     new Chart(ctxBar, {
//         type: 'bar',
//         data: {
//             labels: bulanLabels,
//             datasets: [{
//                 label: 'Total Pemasukan',
//                 data: pemasukanData,
//                 backgroundColor: 'rgba(255,255,255,0.7)',
//                 borderRadius: 8,
//                 barThickness: 30
//             }]
//         },
//         options: {
//             ...commonOptions,
//             plugins: {
//                 ...commonOptions.plugins,
//                 title: { ...commonOptions.plugins.title, text: 'Grafik Pemasukan (Bar)' }
//             }
//         }
//     });
// });

document.addEventListener("DOMContentLoaded", function () {
    const bulanLabels = {!! json_encode($tenantsPerMonth->pluck('bulan')) !!};
    const pemasukanData = {!! json_encode($tenantsPerMonth->pluck('total_pemasukan')) !!};
    const jumlahPenghuniData = {!! json_encode($tenantsPerMonth->pluck('jumlah_penghuni')) !!};
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            title: {
                display: true,
                text: '', 
                color: '#000',                  // judul hitam
                font: { size: 18, weight: 'bold' },
                padding: { top: 10, bottom: 10 }
            }
        },
        layout: {
            padding: { left: 10, right: 10, top: 10, bottom: 10 }
        },
        scales: {
            x: {
                ticks: {
                    color: '#333',               // label sumbu X warna gelap
                    font: { size: 13, weight: '500' },
                },
                grid: { display: false }
            },
            y: {
                ticks: {
                    color: '#333',              // label sumbu Y warna gelap
                    font: { size: 13, weight: '500' },
                    callback: value =>  value.toLocaleString('id-ID')
                },
                grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false }
            }
        }
    };

    const ctxLine = document.getElementById('lineChart').getContext('2d');
    const gradientLine = ctxLine.createLinearGradient(0, 0, 0, 300);
    gradientLine.addColorStop(0, 'rgba(252, 217, 44, 0.4)');
    gradientLine.addColorStop(1, 'rgba(252, 217, 44, 0.05)');

    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Total Pemasukan',
                data: pemasukanData,
                borderColor: '#fcd92c',
                backgroundColor: gradientLine,
                pointBackgroundColor: '#fcd92c',
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            ...commonOptions,
            plugins: {
                ...commonOptions.plugins,
                title: { ...commonOptions.plugins.title, text: 'Grafik Pemasukan' }
            }
        }
    });

    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Jumlah Penghuni Aktif',
                data: jumlahPenghuniData,
                backgroundColor: '#fcd92c',   // batang kuning solid
                borderRadius: 8,
                barThickness: 30
            }]
        },
        options: {
            ...commonOptions,
            plugins: {
                ...commonOptions.plugins,
                title: { ...commonOptions.plugins.title, text: 'Jumlah Penghuni Aktif' }
            }
        }
    });
});




</script>



@endsection