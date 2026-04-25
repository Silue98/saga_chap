@extends('components.layouts.app')

@section('title', $betail->race . ' — SagaChap')

@section('content')
<div class="container mt-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            @if($betail->categorie)
                <li class="breadcrumb-item">
                    <a href="{{ route('home', ['categorie' => $betail->categorie->id_categorie]) }}">
                        {{ $betail->categorie->nom_categorie }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ $betail->race }}</li>
        </ol>
    </nav>

    <div class="row g-4">

        {{-- Colonne gauche : galerie --}}
        <div class="col-lg-6">

            {{-- Image principale --}}
            <div class="rounded overflow-hidden mb-2 border" style="background:#f8f9fa;">
                @php
                    $images = $betail->images;
                    $video  = $betail->video_media;
                @endphp

                @if($images->isNotEmpty())
                    <img id="main-photo"
                         src="{{ asset('storage/' . $images->first()->chemin) }}"
                         alt="{{ $betail->race }}"
                         class="w-100"
                         style="height:380px;object-fit:contain;">
                @elseif($betail->photo)
                    <img src="{{ asset('storage/' . $betail->photo) }}"
                         alt="{{ $betail->race }}"
                         class="w-100"
                         style="height:380px;object-fit:contain;">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light"
                         style="height:380px;">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                @endif
            </div>

            {{-- Miniatures images --}}
            @if($images->count() > 1)
                <div class="d-flex gap-2 flex-wrap mb-2">
                    @foreach($images as $img)
                        <img src="{{ asset('storage/' . $img->chemin) }}"
                             alt="Photo {{ $loop->iteration }}"
                             onclick="document.getElementById('main-photo').src = this.src; this.closest('.d-flex').querySelectorAll('img').forEach(i=>i.style.border='2px solid #dee2e6'); this.style.border='2px solid #198754';"
                             class="rounded border"
                             style="width:72px;height:72px;object-fit:contain;cursor:pointer;transition:opacity .2s;{{ $loop->first ? 'border:2px solid #198754!important;' : '' }}"
                             onmouseover="this.style.opacity='0.7'"
                             onmouseout="this.style.opacity='1'">
                    @endforeach
                </div>
            @endif

            {{-- Lecteur vidéo --}}
            @if($video)
                <div class="mt-3">
                    <p class="fw-semibold mb-2">
                        <i class="fas fa-video me-2 text-success"></i>Vidéo de présentation
                    </p>
                    <video controls class="w-100 rounded border" style="max-height:280px;background:#000;" preload="metadata">
                        <source src="{{ asset('storage/' . $video->chemin) }}" type="video/mp4">
                        <source src="{{ asset('storage/' . $video->chemin) }}" type="video/webm">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                </div>
            @elseif($betail->video)
                <div class="mt-3">
                    <p class="fw-semibold mb-2">
                        <i class="fas fa-video me-2 text-success"></i>Vidéo de présentation
                    </p>
                    <video controls class="w-100 rounded border" style="max-height:280px;background:#000;" preload="metadata">
                        <source src="{{ asset('storage/' . $betail->video) }}" type="video/mp4">
                        <source src="{{ asset('storage/' . $betail->video) }}" type="video/webm">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                </div>
            @endif

        </div>

        {{-- Colonne droite : infos + achat --}}
        <div class="col-lg-6">
            <div class="d-flex align-items-center gap-2 mb-2">
                @if($betail->categorie)
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        {{ $betail->categorie->nom_categorie }}
                    </span>
                @endif
                <span class="badge {{ $betail->disponibilite ? 'bg-success' : 'bg-danger' }}">
                    {{ $betail->disponibilite ? 'Disponible' : 'Indisponible' }}
                </span>
            </div>

            <h1 class="fw-bold mb-1">{{ $betail->race }}</h1>
            <p class="text-muted mb-3">
                <i class="fas fa-map-marker-alt me-1"></i>{{ $betail->origine }}
            </p>

            <div class="bg-success-subtle rounded p-3 mb-4">
                <span class="fs-2 fw-bold text-success">
                    {{ number_format($betail->prix, 0, ',', ' ') }} FCFA
                </span>
            </div>

            {{-- Caractéristiques --}}
            <div class="row g-2 mb-4">
                <div class="col-6">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-birthday-cake text-success d-block mb-1"></i>
                        <small class="text-muted d-block">Âge</small>
                        <strong>{{ $betail->age }} an{{ $betail->age > 1 ? 's' : '' }}</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-weight text-success d-block mb-1"></i>
                        <small class="text-muted d-block">Poids</small>
                        <strong>{{ $betail->poids }} kg</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-map-marker-alt text-success d-block mb-1"></i>
                        <small class="text-muted d-block">Origine</small>
                        <strong>{{ $betail->origine }}</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-boxes text-success d-block mb-1"></i>
                        <small class="text-muted d-block">Stock</small>
                        <strong>{{ $betail->quantite }} disponible(s)</strong>
                    </div>
                </div>
            </div>

            {{-- Formulaire ajout panier --}}
            @if($betail->disponibilite && $betail->quantite > 0)
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="betail_id" value="{{ $betail->id_betail }}">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <label class="fw-semibold mb-0">Quantité :</label>
                        <input type="number" name="quantite"
                               value="1" min="1" max="{{ $betail->quantite }}"
                               class="form-control"
                               style="width:90px;">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-lg flex-fill">
                            <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
                        </button>
                        <a href="{{ route('cart.checkout') }}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-bolt me-1"></i>Commander
                        </a>
                    </div>
                </form>
            @else
                <button class="btn btn-secondary btn-lg w-100" disabled>
                    <i class="fas fa-times-circle me-2"></i>Indisponible
                </button>
            @endif

            {{-- Avantages --}}
            <div class="mt-4 p-3 bg-light rounded">
                <small class="text-muted">
                    <i class="fas fa-truck text-success me-2"></i>Livraison à domicile disponible<br>
                    <i class="fas fa-hand-holding-usd text-success me-2"></i>Paiement à la livraison<br>
                    <i class="fas fa-phone text-success me-2"></i>Confirmation par appel
                </small>
            </div>
        </div>
    </div>

    {{-- ===== LOCALISATION EN TEMPS RÉEL ===== --}}
    <div class="mt-5">
        <h4 class="fw-bold mb-3">
            <i class="fas fa-map-marker-alt me-2 text-success"></i>Localisation de la bête en direct
        </h4>

        @if($betail->localisation_lat && $betail->localisation_lng)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white d-flex align-items-center gap-2">
                    <span class="badge bg-light text-success">
                        <i class="fas fa-circle me-1" style="font-size:8px;color:#28a745;animation:pulse 1.5s infinite;"></i>
                        En direct
                    </span>
                    <span>Position actuelle — Mise à jour automatique</span>
                </div>
                <div class="card-body p-0" style="height:350px;position:relative;">
                    <div id="map-betail" style="height:100%;width:100%;border-radius:0 0 8px 8px;"></div>
                </div>
                <div class="card-footer small text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Dernière position enregistrée :
                    @if($betail->localisation_updated_at)
                        {{ \Carbon\Carbon::parse($betail->localisation_updated_at)->diffForHumans() }}
                    @else
                        Disponible
                    @endif
                    — Coordonnées : {{ $betail->localisation_lat }}, {{ $betail->localisation_lng }}
                </div>
            </div>

            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const lat = {{ $betail->localisation_lat }};
                    const lng = {{ $betail->localisation_lng }};

                    const map = L.map('map-betail').setView([lat, lng], 14);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    const icon = L.divIcon({
                        html: '<div style="background:#198754;color:white;border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 2px 8px rgba(0,0,0,0.3);border:2px solid white;">🐄</div>',
                        iconSize: [40, 40],
                        iconAnchor: [20, 20],
                        className: ''
                    });

                    const marker = L.marker([lat, lng], { icon })
                        .addTo(map)
                        .bindPopup(`
                            <strong>{{ $betail->race }}</strong><br>
                            {{ $betail->origine }}<br>
                            <span class="text-muted">{{ number_format($betail->prix, 0, ',', ' ') }} FCFA</span>
                        `)
                        .openPopup();

                    // Cercle de zone approximative
                    L.circle([lat, lng], { radius: 500, color: '#198754', fillOpacity: 0.08, weight: 1 }).addTo(map);

                    // Auto-refresh toutes les 30s
                    setInterval(function () {
                        fetch('/api/betails/{{ $betail->id_betail }}/location')
                            .then(r => r.json())
                            .then(data => {
                                if (data.lat && data.lng) {
                                    marker.setLatLng([data.lat, data.lng]);
                                    map.panTo([data.lat, data.lng]);
                                }
                            })
                            .catch(() => {});
                    }, 30000);
                });
            </script>
            <style>
                @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
            </style>
        @else
            <div class="card border-0 bg-light">
                <div class="card-body text-center py-4">
                    <i class="fas fa-map-marked-alt fa-3x text-muted mb-3 d-block"></i>
                    <p class="text-muted mb-0">La localisation en direct n'est pas encore disponible pour ce bétail.</p>
                    <small class="text-muted">Contactez-nous pour connaître l'emplacement exact.</small>
                </div>
            </div>
        @endif
    </div>

    {{-- Suggestions --}}
    @if($suggestions->isNotEmpty())
        <hr class="my-5">
        <h4 class="fw-bold mb-4">
            <i class="fas fa-th-large me-2 text-success"></i>Vous aimerez aussi
        </h4>
        <div class="row g-3">
            @foreach($suggestions as $s)
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        @php
                            $img = $s->images()->first();
                        @endphp
                        @if($img)
                            <img src="{{ asset('storage/' . $img->chemin) }}"
                                 class="card-img-top"
                                 style="height:140px;object-fit:contain;"
                                 alt="{{ $s->race }}">
                        @elseif($s->photo)
                            <img src="{{ asset('storage/' . $s->photo) }}"
                                 class="card-img-top"
                                 style="height:140px;object-fit:contain;"
                                 alt="{{ $s->race }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                 style="height:140px;">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body p-2">
                            <p class="fw-semibold mb-0 small">{{ $s->race }}</p>
                            <p class="text-success fw-bold small mb-1">
                                {{ number_format($s->prix, 0, ',', ' ') }} FCFA
                            </p>
                            <a href="{{ route('betails.show', $s->id_betail) }}"
                               class="btn btn-outline-success btn-sm w-100">Voir</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
