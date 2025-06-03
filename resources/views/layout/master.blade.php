<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Igloo Indekos</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset ('assets/css/dashboard-index.css')}}">
  <link rel="stylesheet" href=" {{ asset ('assets/css/style.css')}}">
  
</head>
<body>

  <div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
    
          <h2><img src="assets/img/IndekostLogo.svg" alt="Logo"> Igloo Indekos</h2>
          <a href="/dashboard-index" class="active"><i class='bx bx-home-alt'></i> Dashboard</a>
          <a href="{{route('dashboard-kamar', ['id' => $property->id])}}"><i class='bx bx-bed'></i> Data Kamar</a>
          <a href="penghuni.html"><i class='bx bx-user'></i> Data Penghuni</a>
          <a href="pembayaran.html"><i class='bx bx-wallet'></i> Data Pembayaran</a>
          <a href="pemesanan.html"><i class='bx bx-file'></i> Data Pemesanan</a>
          <a href="#"><i class='bx bx-cog'></i> Pengaturan</a>
          <li>
            <a href="#" data-resize-btn>
              <i class='bx bx-chevrons-right'></i>
              <span>Collapse</span>
            </a>
          </li>

      
    </div>

    <!-- Main Content -->
    @yield('content')

    <script>
      const resizeBtn = document.querySelector('[data-resize-btn]');
    resizeBtn.addEventListener('click', function(e) {
      e.preventDefault();
      document.body.classList.toggle('sb-collapsed');
    });
      
    // function toggleAddModal() {
    //     const modal = document.getElementById('tenantModal');
    //     modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
    // };

    
</script>
    {{-- <script src="{{ asset ('assets/js/room.js')}}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script> --}}
    

</body>
</html>
