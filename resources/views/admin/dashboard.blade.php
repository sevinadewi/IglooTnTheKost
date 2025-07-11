@extends('layout.admin-master')

@section('styles')
    <style>
        canvas {
            max-width: 50px;
        }
        .dashboard-container {
    display: flex;
    flex-direction: column; /* arah atas ke bawah */
    height: 100vh;
    width: 100%;
}


    </style>
@endsection

@section('content')

<div class="dashboard-container">
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
<div class="main-content">
    <h2>Statistik Sistem</h2>

    <div class="info-cards">
        <div class="card-container">
          
            <div class="card green">
              <div class="card-header">{{ $userCount }}</div>
              <div class="card-label">Jumlah Pengguna</div>
              <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>
            <div class="card yellow">
                <div class="card-header">{{ $adminCount }}</div>
              <div class="card-label">Jumlah Admin</div>
              
              <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>
            <div class="card blue">
              <div class="card-header">{{ $propertyCount }}</div>
              <div class="card-label">Jumlah Properti</div>
              <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>
          
        </div>
    </div>
    <div style="max-width: 500px;">
        <h4 style="margin-bottom: 10px; color: #333;"></h4>
        <canvas id="propertyChart" height="120" style="max-width: 100%; margin-bottom: 40px;"></canvas>
    </div>
    
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
  const ctx = document.getElementById('propertyChart').getContext('2d');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Pengguna', 'Admin', 'Properti'],
      datasets: [{
        label: 'Jumlah',
        data: [{{ $userCount }}, {{ $adminCount }}, {{ $propertyCount }}],
        backgroundColor: [
          '#EBC005', // Kuning tema
          '#FFB300', // Kuning terang
          '#FFD54F'  // Kuning pastel
        ],
        borderRadius: 10,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#333',
          titleColor: '#fff',
          bodyColor: '#fff'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            color: '#333',
            font: { weight: 'bold' }
          }
        },
        x: {
          ticks: {
            color: '#333',
            font: { weight: 'bold' }
          }
        }
      }
    }
  });
});
</script>
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



    {{-- Tambahkan Chart di sini --}}
</div>
@endsection
