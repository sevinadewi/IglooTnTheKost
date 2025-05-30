@extends('layout.master')
@section('content')
    <div class="main-content">
      <div class="topbar">
        <i class='bx bx-user-circle'></i>
      </div>
      
          
     
      <h2>Selamat Datang! Admin {{ $property->nama }}</h2>

      <div class="info-cards">
        <div class="card-container">
          <div class="column">
            <div class="card green">
              <div class="card-header">4</div>
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
              <div class="card-header">6</div>
              <div class="card-label">Penghuni Aktif</div>
              <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>

            <div class="card red">
              <div class="card-header">0 <small style="font-size: 12px;">/Bulan</small></div>
              <div class="card-label">Penghuni Non-Aktif</div>
              <div class="card-footer">More Info <i class='bx bx-right-arrow-alt'></i></div>
            </div>
          </div>
  
@endsection