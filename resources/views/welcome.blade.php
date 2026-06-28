@extends('layouts.base_vitrine')
<style>

    .highlight-bar {
      overflow: hidden;
      white-space: nowrap;
      animation: scroll 12s linear infinite;
      font-weight: bold;
      font-size: 1.1rem;
    }

    @keyframes scroll {
      0%   { transform: translateX(100%); }
      100% { transform: translateX(-100%); }
    }
    #contact label {
      color: white !important;
    }


  </style>
@section('content')

  <!-- BANNIÈRE DÉFILANTE -->

  @if($setting)
    <div class="mt-3 bg-light">
      <div class="highlight-bar text-center">
        {!! $setting->content !!}
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif

  <!-- TITRE -->
  <div class="bg-light text-center mt-3">
    <img src="{{ asset('images/logo_rhetoria.png') }}" alt="logo" style="width: 120px; height: 120px;">
    <h1 class="fw-bold fs-1 padding-top bg-light">Rhétoria</h1>
    <p class="lead bg-light">L’art de convaincre, le plaisir de parler !</p>
    <a href="#" class="btn btn-lg btn-warning text-white" data-bs-toggle="modal" data-bs-target="#helloassoModal">Adhérer</a>
    <a href="https://www.helloasso.com/associations/eloquencia/evenements/atelier-eloquencia" class="btn btn-lg btn-outline-warning">Participer aux ateliers</a>
      <!--@guest('member')<a href="{{ url('/login') }}" class="btn btn-sm btn-warning">Connexion</a>@endguest
    @auth('member')<a href="{{ url('/lms') }}" class="btn btn-sm btn-warning">Accès au cours</a>@endauth -->
  </div>

  <!-- CAROUSEL -->
  <div id="carouselEloquencia" class="carousel slide mt-4 bg-light" data-bs-ride="carousel" data-bs-interval="6000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('images/carousel/banner1.webp') }}" class="d-block w-100" alt="Image 1" style="height: 400px; object-fit: cover;">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/carousel/banner2.webp') }}" class="d-block w-100" alt="Image 2" style="height: 400px; object-fit: cover;">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/carousel/banner3.webp') }}" class="d-block w-100" alt="Image 2" style="height: 400px; object-fit: cover;">
      </div>
      <div class="carousel-item">
          <img src="{{ asset('images/carousel/banner4.webp') }}" class="d-block w-100" alt="Image 2" style="height: 400px; object-fit: cover;">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselEloquencia" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselEloquencia" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
  </div>

  <!-- DEMANDE DE REDUCTION -->
  <!-- <p class="text-muted text-center mt-3">
  Étudiant·e ou moins de 18 ans ? Vous pouvez <a href="{{ url('/reduction') }}">faire une demande de réduction ici</a>.
  </p> -->

  <!-- SECTION ARTICLES -->
  <div class="container py-5">
    <h2 class="text-center mb-4 fw-bold">Article à la une :</h2>
        <div class="row g-4 justify-content-center">
          @foreach($articles as $article)

            <div class="col-md-4">
              <div class="card h-100 shadow">
                <img src="{{ $article->pic }}" alt="Image" class="card-img-top" style="height: 400px; object-fit: cover;">
                <div class="card-body text-center">
                  <h5 class="card-title">{{ $article->title }}</h5>
                  <p class="card-text">{{ $article->summary }}</p>
                  <a href="{{ route('article.show', $article->id) }}" class="btn btn-outline-warning">Lire plus</a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <!-- LIEN VERS BLOG -->
        <div class="text-center mt-4">
          <a href="{{ url('/blog') }}" class="btn btn-outline-warning px-4 fw-bold">Voir tous les articles →</a>
        </div>
  </div>

  <!-- SECTION PARTENAIRES -->
  <section class="py-5 bg-light" id="partenaires">
    <div class="container">
      <h2 class="text-center fw-bold mb-5">Nos Partenaires</h2>
        <div class="row g-4 justify-content-center">
            @foreach ($partenaires as $data)
              @php
                $partenaire = json_decode($data->value);
              @endphp
              <div class="col-md-6 col-lg-4">
                <div class="bg-white rounded shadow p-4 h-100 d-flex flex-column">
                  <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset($partenaire->image) }}" alt="Logo partenaire" class="me-3 rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                    <div>
                      <h5 class="mb-0">{{ $partenaire->nom }}</h5>
                      <small class="text-muted">Depuis {{ $partenaire->depuis }}</small>
                    </div>
                  </div>
                  <p class="text-muted flex-grow-1">{{ $partenaire->description }}</p>
                    <a href="{{ $partenaire->link }}" class="btn btn-sm btn-outline-warning mt-3 align-self-start" target="_blank">En savoir plus</a>
                </div>
              </div>
            @endforeach
        </div>
    </div>
  </section>

  <!-- SECTION REDUCTION -->
  <section class="py-5 bg-light" id="discount">
      <div class="container">
          <h2 class="text-center fw-bold mb-5">Réduction</h2>
          <div class="row g-4 justify-content-center">
                  <div class="col-md-6 col-lg-10">
                      <div class="bg-white rounded shadow p-4 h-100 d-flex flex-column">
                          <div class="d-flex align-items-center mb-3">
                              <img src="{{ asset('images/reduction.webp') }}" alt="Image reduction" class="me-3 img-fluid rounded" style="max-width: 450px; max-height: 300px; object-fit: cover;">
                              <p class="flex-grow-1">Vous avez moins de 18 ans ou vous êtes étudiant ? Bénéficiez de -5€ sur votre adhésion !
                                  Demandez une réduction en envoyant un e-mail à <a href="mailto:contact@rhetoria.fr">contact@rhetoria.fr</a> avec un justificatif (carte d'étudiant, certificat de scolarité, pièce d'identité...).
                              </p>
                          </div>
                          <a href="mailto:contact@rhetoria.fr" class="btn btn-sm btn-warning mt-3 align-self-end text-white" target="_blank">Envoyer un e-mail</a>
                      </div>
                  </div>
          </div>
      </div>
  </section>

  <!-- FORMULAIRE DE CONTACT -->
  <section class="py-5 bg-light" id="contact">
    <div class="container">
      <h2 class="text-center mb-4 fw-bold">Contactez-nous</h2>
      <form method="POST" action="/envoie_mess" class="p-4 shadow bg-warning rounded mx-auto" style="max-width: 700px;" autocomplete="off">
      @csrf <!-- PROTECTION CSRF -->
      @if ($errors->has('throttle'))
        <div class="alert alert-danger text-center">
          {{ $errors->first('throttle') }}
        </div>
      @endif
        <div class="mb-3">
          <label for="name" class="form-label">Nom Prénom</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Jean Montrouge" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Adresse email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="jean.montrouge@mail.fr" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea class="form-control" id="message" name="message" rows="4" placeholder="Votre message..." required></textarea>
        </div>
        <div class="mb-3 mt-3">
          <label for="captcha" class="form-label">Captcha</label>
          <div class="d-flex align-items-center gap-3 mb-2">
            <img src="{{ route('captcha.image') }}" alt="captcha" id="captcha-img" style="height: 30px; width: 65px; border-radius: 8px;">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('captcha-img').src='{{ route('captcha.image') }}?rand=' + Math.random();">
              🔁
            </button>
          </div>
          <input type="text" name="captcha" id="captcha" class="form-control" required>
          @error('captcha')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror

          <input class="form-check-input mt-2" type="checkbox" id="cgu" name="cgu" required>
          <label class="form-check-label mt-1" for="cgu">J’accepte les <a href="/legals" target="_blank" class="cgu-link text-white" >conditions générales d’utilisation des données</a></label>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-light px-4">Envoyer</button>
        </div>
      </form>

      <!-- Modal de mise en garde -->
      <div class="modal fade" id="emailWarningModal" tabindex="-1" aria-labelledby="emailWarningLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-warning">
            <div class="modal-header bg-warning">
              <h5 class="modal-title fw-bold" id="emailWarningLabel">Attention !</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
              Les adresses <strong>@icloud.com</strong> et <strong>@sfr.fr</strong> peuvent poser problème pour la réception des e-mails.
              <br><br>
              Si possible, utilisez une autre adresse (ex: Gmail, Outlook...).
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-main" data-bs-dismiss="modal">J'ai compris</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
  <div class="modal fade" id="helloassoModal" tabindex="-1" aria-labelledby="helloassoModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">

              <div class="modal-header">
                  <h5 class="modal-title" id="helloassoModalLabel">Redirection externe</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
              </div>

              <div class="modal-body">
                  Vous allez être redirigé vers le site de HelloAsso pour finaliser votre adhésion.
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                  <a href="https://www.helloasso.com/associations/eloquencia/adhesions/adhesion-2025-2026" target="_blank" class="btn btn-warning">Continuer</a>
              </div>

          </div>
      </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const bar = document.querySelector('.highlight-bar');
      if (bar) {
        bar.addEventListener('mouseenter', function() {
          bar.style.animationPlayState = 'paused';
        });
        bar.addEventListener('mouseleave', function() {
          bar.style.animationPlayState = 'running';
        });
      }
    });
  </script>
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

@endsection
