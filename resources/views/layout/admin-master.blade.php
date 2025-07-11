<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin Minkos</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet"/>
  <!-- Bootstrap & Boxicons -->
  {{-- <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css" /> --}}
  <link rel="stylesheet" href="assets/vendor/boxicons/css/boxicons.min.css" />
  <link rel="stylesheet" href="{{ asset ('assets/css/dashboard-index.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset ('assets/css/dashboard-index-new.css')}}"> --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href=" {{ asset ('assets/css/style.css')}}">
    {{-- <link rel="stylesheet" href=" {{ asset ('assets/css/style-new.css')}}"> --}}
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
      <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  @yield('styles')
</head>
<body>

  <div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        @if(isset($user))
        <h2><img src="{{ asset('assets/img/IndekostLogo.svg') }}" alt="Logo">  Minkos</h2>
          
        <a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
            <i class='bx bx-home-alt'></i> <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.edit-user-role', ['id' => Auth::id()]) }}">
            <i class='bx bx-user-pin'></i> <span>Edit Akses Properti</span>
        </a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
    // Toggle sidebar di HP (responsive)
function toggleSidebar() {
    document.body.classList.toggle('sb-open');
}

// Tutup sidebar jika klik di luar
window.addEventListener('click', function(e) {
    if (document.body.classList.contains('sb-open')) {
        const sidebar = document.querySelector('.sidebar');
        const toggle = document.querySelector('.toggle-sidebar');
        if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
            document.body.classList.remove('sb-open');
        }
    }
});

    // Collapse sidebar
    document.addEventListener('DOMContentLoaded', function() {
    const resizeButton = document.querySelector('[data-resize-btn]');
    if (resizeButton) {
        resizeButton.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sb-collapsed');
        });
    }
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
