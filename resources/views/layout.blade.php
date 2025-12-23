<!doctype html>
<html lang="en">

<head>
  <title>@yield('title', 'Sistem Informasi Bengkel')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>
    body{font-family:'Poppins',sans-serif;background:#F4F6F9}
    #sidebar{background:#072D44}
    #sidebar a{color:#fff}
    #sidebar a:hover{color:#9CCDDB}
    .navbar{background:#fff;border-bottom:1px solid #ddd}
    .card{border:none;border-radius:18px;box-shadow:0 10px 25px rgba(0,0,0,.08)}
    .btn-main{background:#5790AB;color:#fff;border-radius:10px}
    .btn-main:hover{background:#064469;color:#fff}
    .table thead{background:#072D44;color:#fff}
    .nav-divider{height:1px;background-color:rgba(255,255,255,.1);margin:10px 0}
    #sidebar .collapse{display:none}
    #sidebar .collapse.show{display:block}
  </style>
</head>
<body>

  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="p-4 pt-5">
        <a href="{{ route('home') }}" class="img logo rounded-circle mb-5" style="background-image: url({{ asset('images/hkotak.jpeg') }});"></a>
        <div class="mb-3">
          <small style="color: #9CCDDB;">
            <strong>{{ auth()->user()->name }}</strong><br>
            <span class="badge {{ auth()->user()->role === 'admin' ? 'bg-danger' : 'bg-info' }}">{{ ucfirst(auth()->user()->role) }}</span>
          </small>
        </div>
        <ul class="list-unstyled components mb-5">
          <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}">Home</a>
          </li>

          {{-- Admin Only Menu Items --}}
          @if(auth()->user()->role === 'admin')
            <li class="nav-divider"></li>
            <li>
              <a href="#masterSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-cogs"></i> Master Data
              </a>
              <ul class="collapse list-unstyled" id="masterSubmenu">
                <li class="{{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                  <a href="{{ route('pelanggan.index') }}" style="padding-left: 30px;">Pelanggan</a>
                </li>
                <li class="{{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
                  <a href="{{ route('kendaraan.index') }}" style="padding-left: 30px;">Kendaraan</a>
                </li>
                <li class="{{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                  <a href="{{ route('pegawai.index') }}" style="padding-left: 30px;">Pegawai</a>
                </li>
                <li class="{{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                  <a href="{{ route('supplier.index') }}" style="padding-left: 30px;">Supplier</a>
                </li>
                <li class="{{ request()->routeIs('bahanbaku.*') ? 'active' : '' }}">
                  <a href="{{ route('bahanbaku.index') }}" style="padding-left: 30px;">Bahan Baku</a>
                </li>
              </ul>
            </li>
            <li class="{{ request()->routeIs('barangjadi.*') ? 'active' : '' }}">
              <a href="{{ route('barangjadi.index') }}">Barang Jadi</a>
            </li>
            <li class="nav-divider"></li>
            <li class="{{ request()->routeIs('penjualan.*') ? 'active' : '' }}">
              <a href="{{ route('penjualan.index') }}">Penjualan</a>
            </li>
            <li class="{{ request()->routeIs('pembelian.*') ? 'active' : '' }}">
              <a href="{{ route('pembelian.index') }}">Pembelian</a>
            </li>
            <li class="nav-divider"></li>
            <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
              <a href="{{ route('users.index') }}"><i class="fas fa-users"></i> Kelola User</a>
            </li>
          @else
            {{-- Cashier Menu Items --}}
            <li class="{{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
              <a href="{{ route('pelanggan.index') }}">Pelanggan</a>
            </li>
            <li class="{{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
              <a href="{{ route('kendaraan.index') }}">Kendaraan</a>
            </li>
            <li class="{{ request()->routeIs('barangjadi.*') ? 'active' : '' }}">
              <a href="{{ route('barangjadi.index') }}">Barang Jadi</a>
            </li>
            <li class="{{ request()->routeIs('penjualan.*') ? 'active' : '' }}">
              <a href="{{ route('penjualan.index') }}">Penjualan</a>
            </li>
          @endif

          <li class="nav-divider"></li>
          <li>            
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
        <div class="footer">
          <p>Mbd &copy;<script>document.write(new Date().getFullYear());</script></p>
        </div>
      </div>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
          </button>
        </div>
      </nav>

      @yield('content')

    </div>
  </div>

  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/popper.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>