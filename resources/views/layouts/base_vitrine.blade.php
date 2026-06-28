<!DOCTYPE html>
<html lang="fr">
<head>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Martian+Mono:wght@400;600;700&display=swap" rel="stylesheet">
  <meta charset="UTF-8">
  <title>Rhétoria</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo_rhetoria.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Rhétoria est une association loi 1901 visant à promouvoir l'éloquence et l'art oratoire">
    <meta name="keywords" content="rhetoria, eloquence, oratoire, association, loi 1901, parler en public, discours, formation, cours en ligne">
    <meta name="author" content="Rhétoria">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">
    <meta name="language" content="fr">
    <meta property="og:site_name" content="Rhétoria">
    <meta property="og:site" content="https://rhetoria.fr">
    <meta property="og:title" content="Accueil">
    <meta property="og:description" content="Rhétoria est une association loi 1901 visant à promouvoir l'éloquence et l'art oratoire">
    <script async="" src="https://analytics.rhetoria.fr/matomo.js"></script>
    <script src="/js/analytics.js"></script>
    <script defer type="text/javascript" src="/js/klaro-config.js"></script>
    <script defer type="text/javascript" src="https://cdn.kiprotect.com/klaro/v0.7.22/klaro.js"></script>
    <link rel="stylesheet" href="https://cdn.kiprotect.com/klaro/v0.7.22/klaro.min.css" />
    <noscript><p><img referrerpolicy="no-referrer-when-downgrade" data-src="https://analytics.rhetoria.fr/matomo.php?idsite=1&amp;rec=1" style="border:0;" alt="" data-type="image" data-name="matomo"/></p></noscript>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/rhetoria.css') }}">

  <style>

  :root {
  --bs-warning: #005dff;
  --bs-warning-rgb: 0, 93, 255;
  }
  .btn-warning {
  background-color: #005dff !important;
  border-color: #005dff !important;
  }

  .btn-warning:hover {
  filter: brightness(90%);
  }

  .btn-outline-warning {
  color: #005dff !important;
  border-color: #005dff !important;
  }

  .btn-outline-warning:hover {
  background-color: #005dff !important;
  color: white !important;
  }

  /*mettre en blanc les liens cliquables dans la bannière en haut */
  .navbar .nav-link {
  color: white !important;
  }
  </style>



  <!-- Icons8 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="pt-5 bg-light">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-warning shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <img src="{{ asset('images/logo_rhetoria.png') }}" alt="Logo" width="40" height="40" class="me-2">
        <strong class="text-white" >Rhétoria</strong>
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
        © 2025 <strong>Rhétoria</strong> | Fait avec 💙 et hébergé en France | <a href="/legals">Mentions légales</a>
        </small>
    </div>
    </footer>
  </main>
</div>



  <!-- Scripts Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <div id="klaro" style="--button-text-color: #fff; --dark1: #fafafa; --dark2: #777; --dark3: #555; --light1: #444; --light2: #666; --light3: #111; --green3: #f00; --notice-top: 20px; --notice-bottom: auto; --notice-left: 20px; --notice-right: auto; --notice-max-width: calc(100vw - 60px); --notice-position: fixed;"><div lang="fr" class="klaro"><div id="cookieScreen" class="cookie-modal"><div class="cm-bg"></div><div class="cm-modal cm-klaro"><div class="cm-header"><h1 class="title"><span><span>Services que nous souhaitons utiliser</span></span></h1><p><span><span>Vous pouvez ici évaluer et personnaliser les services que nous aimerions utiliser sur ce site. C'est vous qui décidez ! Activez ou désactivez les services comme bon vous semble.</span><span> </span><span>Pour en savoir plus, veuillez lire notre </span><a href="/legal" target="_blank" rel="noopener">politique de confidentialité</a><span>.</span></span></p></div><div class="cm-body"><ul class="cm-purposes"><li class="cm-purpose"><input id="purpose-item-analytics" aria-labelledby="purpose-item-analytics-title" aria-describedby="purpose-item-analytics-description" type="checkbox" class="cm-list-input"><label for="purpose-item-analytics" class="cm-list-label"><span id="purpose-item-analytics-title" class="cm-list-title">Analytics</span><span class="cm-switch"><div class="slider round active"></div></span></label><div id="purpose-item-analytics-description"></div><div class="cm-services"><div class="cm-caret"><a href="#" aria-haspopup="true" aria-expanded="false" tabindex="0"><span>↓</span> 1 service</a></div><ul class="cm-content"><li class="cm-service"><div><input id="service-item-matomo" aria-labelledby="service-item-matomo-title" aria-describedby="service-item-matomo-description" tabindex="-1" type="checkbox" class="cm-list-input"><label for="service-item-matomo" class="cm-list-label"><span id="service-item-matomo-title" class="cm-list-title">Matomo</span><span title="Ce service est chargé par défaut (mais vous pouvez le désactiver)" class="cm-opt-out">(opt-out)</span><span class="cm-switch"><div class="slider round active"></div></span></label><div id="service-item-matomo-description"><p class="purposes">Objet: Analytics</p></div></div></li></ul></div></li></ul></div><div class="cm-footer"><div class="cm-footer-buttons"><button type="button" class="cm-btn cm-btn-decline cm-btn-danger cn-decline">Je refuse</button><button type="button" class="cm-btn cm-btn-success cm-btn-info cm-btn-accept">Accepter sélectionné</button><button type="button" class="cm-btn cm-btn-success cm-btn-accept-all">Accepter tout</button></div><p class="cm-powered-by"><a target="_blank" href="https://kiprotect.com/klaro" rel="noopener">Réalisé avec Klaro !</a></p></div></div></div></div></div>
</body>
</html>
