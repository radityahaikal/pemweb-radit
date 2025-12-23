<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sistem Informasi Purbalingga Knalpot</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<!-- Bootstrap -->
<link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<style>
body{
  font-family:'Poppins',sans-serif;
  background:#0B1C26;
  color:#EAEAEA;
}

/* NAVBAR */
.navbar{
  background:#0B1C26;
  border-bottom:2px solid #C9A24D;
}
.navbar a{
  color:#C9A24D !important;
  font-weight:500;
}
.navbar a:hover{
  color:#FFD36A !important;
}

/* HERO */
.hero{
  background:
    linear-gradient(rgba(11,28,38,.85),rgba(11,28,38,.85)), /* Overlay */
    url('{{ asset('images/pngwing.png') }}') center/contain no-repeat;
  height:90vh;
  display:flex;
  align-items:center;
}
.hero h1{
  font-size:52px;
  font-weight:700;
  color:#FFD36A;
}
.hero p{
  font-size:18px;
  margin:20px 0;
  color:#EAEAEA;
}

/* BUTTON */
.btn-main{
  background:linear-gradient(135deg,#C9A24D,#FFD36A);
  border:none;
  color:#0B1C26;
  padding:14px 36px;
  border-radius:40px;
  font-weight:600;
}
.btn-main:hover{
  background:linear-gradient(135deg,#FFD36A,#C9A24D);
  color:#0B1C26;
}

/* SECTION */
.section{
  padding:80px 0;
  background:#0F2734;
}
.section-title h2{
  color:#FFD36A;
  font-weight:700;
}
.section-title p{
  color:#ccc;
}

/* PRODUCT CARD */
.card-product{
  background:#132F40;
  border-radius:18px;
  padding:30px;
  box-shadow:0 15px 35px rgba(0,0,0,.5);
  transition:.3s;
  border:1px solid #C9A24D;
}
.card-product h4{
  color:#FFD36A;
}
.card-product p{
  color:#EAEAEA;
}
.card-product:hover{
  transform:translateY(-8px);
}

/* CONTACT */
.contact{
  background:#0B1C26;
}

/* FOOTER */
.footer{
  background:#08141C;
  color:#C9A24D;
  padding:40px 0;
}
.footer p{
  margin:0;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Purbalingga Knalpot</a>
    </div>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#produk">Produk</a></li>
        <li><a href="#contact">Kontak</a></li>
        <li><a href="{{ route('login') }}" class="btn btn-main">Masuk</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="container text-center">
    <h1>Purbalingga Knalpot</h1>
    <p>Sistem Informasi Bengkel & Produksi Knalpot</p>
    <a href="{{ route('login') }}" class="btn btn-main">Masuk Sistem</a>
  </div>
</section>

<!-- PRODUK -->
<section id="produk" class="section">
  <div class="container">
    <div class="section-title text-center">
      <h2>Produk Unggulan</h2>
      <p>Knalpot custom & bahan berkualitas</p>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="card-product text-center">
          <h4>Leheran Pipa Monel</h4>
          <p>Rp 12.000 / cm</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-product text-center">
          <h4>Monel Panjang</h4>
          <p>Rp 100.000 / kg</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-product text-center">
          <h4>Stainless 26</h4>
          <p>Rp 20.000 / cm</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" class="section contact">
  <div class="container">
    <div class="section-title text-center">
      <h2>Kontak Bengkel</h2>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p><i class="fa fa-map-marker"></i> Purbalingga, Jawa Tengah</p>
        <p><i class="fa fa-phone"></i> 08xxxxxxxx</p>
        <p><i class="fa fa-envelope"></i> info@purbalinggaknalpot.com</p>
      </div>
      <div class="col-md-6">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.1299098966792!2d106.93976347603777!3d-6.246606361166606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698ce4318b9e91%3A0x843c23398a712269!2sPURBALINGGA%20KNALPOT!5e0!3m2!1sen!2sid!4v1748917618313!5m2!1sen!2sid" 
          width="100%" height="250" style="border:0"></iframe>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="container text-center">
    <p>&copy; {{ date('Y') }} Purbalingga Knalpot</p>
  </div>
</footer>

<script src="{{ asset('vendor/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>
