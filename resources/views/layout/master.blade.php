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
      <a href="/dashboard-kamar"><i class='bx bx-bed'></i> Data Kamar</a>
      <a href="penghuni.html"><i class='bx bx-user'></i> Data Penghuni</a>
      <a href="pembayaran.html"><i class='bx bx-wallet'></i> Data Pembayaran</a>
      <a href="pemesanan.html"><i class='bx bx-file'></i> Data Pemesanan</a>
      <a href="#"><i class='bx bx-cog'></i> Pengaturan</a>
    </div>

    <!-- Main Content -->
    @yield('content')


    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/vendor/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/vendor/one-page/scrollIt.min.js"></script>
    <script src="{{ asset ('assets/js/room.js')}}"></script>

</body>
</html>
