<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Eloquéncia</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Eloquéncia est une association loi 1901 visant à promouvoir l'éloquence et l'art oratoire">
    <meta name="keywords" content="eloquence, oratoire, association, loi 1901, parler en public, discours, formation, cours en ligne">
    <meta name="author" content="Eloquéncia">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">
    <meta name="language" content="fr">
    <meta property="og:site_name" content="Eloquéncia">
    <meta property="og:site" content="https://eloquencia.org">
    <meta property="og:title" content="Accueil">
    <meta property="og:description" content="Eloquéncia est une association loi 1901 visant à promouvoir l'éloquence et l'art oratoire">
    <script defer type="text/javascript" src="js/klaro-js/config.js"></script>
    <script defer type="text/javascript" src="https://cdn.kiprotect.com/klaro/v0.7.22/klaro.js"></script>
    <link rel="stylesheet" href="https://cdn.kiprotect.com/klaro/v0.7.22/klaro.min.css" />
    <noscript><img referrerpolicy="no-referrer-when-downgrade" src="https://analytics.eloquencia.org/matomo.php?idsite=1&amp;rec=1" style="border:0" alt="" /></noscript>

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons8 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="pt-5 bg-light">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-warning shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="40" height="40" class="me-2">
        <strong>Eloquéncia</strong>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ url('/services') }}">Nos services</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/blog') }}">Blog</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#partenaires') }}">Partenaires</a></li>
          <!-- <li class="nav-item"><a class="nav-link" href="{{ url('/reduction') }}">Réduction</a></li> -->
          <li class="nav-item"><a class="nav-link" href="{{ url('/#contact') }}">Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">A propos</a></li>
            <!--@guest('member')<li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Connexion</a></li>@endguest
          @auth('member')
          <form method="POST" action="{{ route('member.logout') }}">
            @csrf
            <button type="submit" class="btn nav-link">Déconnexion <i class="bi bi-box-arrow-right"></i></button>
          </form>
          @endauth-->
        </ul>
      </div>
    </div>
  </nav>

  <!-- Contenu principal -->
  <main class="flex-grow-1">
    @yield('content')

    <footer class="bg-light text-center py-3">
    <div class="container">
        <small class="text-muted">
        © 2025 <strong>Eloquéncia</strong> | Fait avec 💙 et hébergé en France | <a href="/legals">Mentions légales</a>
        </small>
    </div>
    </footer>
  </main>
</div>



  <!-- Scripts Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('email');

    emailInput.addEventListener('blur', function () {
      const email = emailInput.value.toLowerCase();

      if (email.includes('@icloud.com') || email.includes('@sfr.fr')) {
        const modal = new bootstrap.Modal(document.getElementById('emailWarningModal'));
        modal.show();
      }
    });
  });


</script>
</body>
</html>
