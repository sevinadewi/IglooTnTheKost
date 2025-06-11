<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Igloo Indekos</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet"/>
  <!-- Bootstrap & Boxicons -->
  <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/vendor/boxicons/css/boxicons.min.css" />
  <link rel="stylesheet" href="{{ asset ('assets/css/dashboard-index.css')}}">
  <link rel="stylesheet" href=" {{ asset ('assets/css/style.css')}}">
  @yield('styles')
</head>
<body>

  <div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
          @if(isset($property))
          <h2><img src="assets/img/IndekostLogo.svg" alt="Logo"> Igloo Indekos</h2>
          
          <a href="{{route('property.dashboard', ['id' => $property->id])}}" class="active"><i class='bx bx-home-alt'></i> Dashboard</a>
          
          <a href="{{route('dashboard-kamar', ['id' => $property->id])}}"><i class='bx bx-bed'></i> Data Kamar</a>
       
          <a href="{{route('dashboard-penghuni', ['id' => $property->id])}}"><i class='bx bx-user'></i> Data Penghuni</a>
          
          <a href="pembayaran.html"><i class='bx bx-wallet'></i> Data Pembayaran</a>
          <a href="pemesanan.html"><i class='bx bx-file'></i> Data Pemesanan</a>
          <a href="#"><i class='bx bx-cog'></i> Pengaturan</a>
          <li>
            <a href="#" data-resize-btn>
              <i class='bx bx-chevrons-right'></i>
              <span>Collapse</span>
            </a>
          </li>
          
          @endif
    </div>

    <!-- Main Content -->
    @yield('content')

    <script>
    //   const resizeBtn = document.querySelector('[data-resize-btn]');
    // resizeBtn.addEventListener('click', function(e) {
    //   e.preventDefault();
    //   document.body.classList.toggle('sb-collapsed');
    // });
      
    // Collapse sidebar
    const resizeButton = document.querySelector('[data-resize-btn]');
    resizeButton.addEventListener('click', function(e) {
      e.preventDefault();
      document.body.classList.toggle('sb-collapsed');
    });

    // Window Scroll
    window.addEventListener('scroll', function() {
      const scrollTop = window.scrollY;
      if(scrollTop >= 100){
        document.body.classList.add('fixed-header');
      } else {
        document.body.classList.remove('fixed-header');
      }
    });
    // function toggleAddModal() {
    //     const modal = document.getElementById('tenantModal');
    //     modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
    // };

    
</script>

    {{-- <script src="{{ asset('assets/js/dashboard.js') }}"></script> --}}
    

</body>
</html>
