@extends('components.layouts.app')

@section('title', 'SagaChap — Le bétail de qualité, à portée de clic')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<div class="sagachap-hero mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="SagaChap"
                         style="width:64px;height:64px;object-fit:contain;border-radius:50%;border:3px solid rgba(255,255,255,0.5);">
                    <h1 class="display-5 fw-bold mb-0 text-white">SÂGACHAP</h1>
                </div>
                <p class="lead fw-bold text-white mb-2" style="font-size:1.4rem;">
                    🐄 Le bétail de qualité, à portée de clic
                </p>
                <p class="text-white-50 mb-4" style="font-style:italic;font-size:1.05rem;">
                    "Même ce que tu penses pas trouver, nous on te livre ça."
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#catalogue" class="btn btn-light btn-lg text-success fw-bold px-4">
                        <i class="fas fa-store me-2"></i>Voir le catalogue
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-shopping-cart me-2"></i>Mon panier
                    </a>
                </div>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="fas fa-cow text-white" style="font-size:9rem;opacity:0.18;"></i>
            </div>
        </div>
    </div>
</div>

{{-- ===== AVANTAGES ===== --}}
<div class="container mb-5">
    <div class="row g-3 text-center">
        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3 bg-success bg-opacity-10 border border-success border-opacity-25 h-100">
                <i class="fas fa-shield-alt text-success fs-3 mb-2"></i>
                <p class="fw-semibold mb-0 small">Bétail certifié</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3 bg-success bg-opacity-10 border border-success border-opacity-25 h-100">
                <i class="fas fa-truck text-success fs-3 mb-2"></i>
                <p class="fw-semibold mb-0 small">Livraison à domicile</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3 bg-success bg-opacity-10 border border-success border-opacity-25 h-100">
                <i class="fas fa-map-marker-alt text-success fs-3 mb-2"></i>
                <p class="fw-semibold mb-0 small">Localisation en direct</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3 bg-success bg-opacity-10 border border-success border-opacity-25 h-100">
                <i class="fas fa-hand-holding-usd text-success fs-3 mb-2"></i>
                <p class="fw-semibold mb-0 small">Paiement à la livraison</p>
            </div>
        </div>
    </div>
</div>

<div class="container" id="catalogue">

    {{-- Filtres actifs --}}
    @if(request('search') || request('categorie'))
        <div class="alert alert-info d-flex align-items-center justify-content-between mb-3">
            <span>
                <i class="fas fa-filter me-2"></i>
                Résultats filtrés
                @if(request('search')) pour "<strong>{{ request('search') }}</strong>"@endif
                @if(request('categorie'))
                    — Catégorie : <strong>{{ $categories->firstWhere('id_categorie', request('categorie'))?->nom_categorie }}</strong>
                @endif
                ({{ $betails->count() }} résultat(s))
            </span>
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times me-1"></i>Effacer les filtres
            </a>
        </div>
    @endif

    {{-- Filtres rapides par catégorie --}}
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('home') }}"
           class="btn btn-sm {{ !request('categorie') ? 'btn-success' : 'btn-outline-success' }}">
            <i class="fas fa-border-all me-1"></i>Tous
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('home', ['categorie' => $cat->id_categorie]) }}"
               class="btn btn-sm {{ request('categorie') == $cat->id_categorie ? 'btn-success' : 'btn-outline-success' }}">
                {{ $cat->nom_categorie }}
            </a>
        @endforeach
    </div>

    {{-- Grille bétails --}}
    <div class="row g-3">
        @forelse($betails as $betail)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0 betail-card">
                    @php $imgMedia = $betail->images()->first(); @endphp

                    {{-- Badge vidéo --}}
                    <div style="position:relative;">
                        <a href="{{ route('betails.show', $betail->id_betail) }}" style="display:block;overflow:hidden;border-radius:8px 8px 0 0;">
                        @if($imgMedia)
                            <img src="{{ asset('storage/' . $imgMedia->chemin) }}"
                                 class="card-img-top"
                                 style="height:200px;object-fit:contain;transition:transform .3s;"
                                 onmouseover="this.style.transform='scale(1.04)'"
                                 onmouseout="this.style.transform='scale(1)'"
                                 alt="{{ $betail->race }}">
                        @elseif($betail->photo)
                            <img src="{{ asset('storage/' . $betail->photo) }}"
                                 class="card-img-top"
                                 style="height:200px;object-fit:contain;transition:transform .3s;"
                                 onmouseover="this.style.transform='scale(1.04)'"
                                 onmouseout="this.style.transform='scale(1)'"
                                 alt="Photo de {{ $betail->race }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                                <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        </a>
                        {{-- Badge vidéo disponible --}}
                        @if($betail->video_media || $betail->video)
                            <span class="badge bg-dark position-absolute" style="top:8px;left:8px;opacity:0.85;">
                                <i class="fas fa-video me-1"></i>Vidéo
                            </span>
                        @endif
                        {{-- Badge localisation --}}
                        @if($betail->localisation_lat && $betail->localisation_lng)
                            <span class="badge bg-primary position-absolute" style="top:8px;right:8px;opacity:0.9;">
                                <i class="fas fa-map-marker-alt me-1"></i>En direct
                            </span>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $betail->race }}</h5>
                            <span class="badge bg-{{ $betail->disponibilite ? 'success' : 'danger' }}">
                                {{ $betail->disponibilite ? 'Dispo' : 'Indispo' }}
                            </span>
                        </div>
                        @if($betail->categorie)
                            <small class="text-muted mb-2">
                                <i class="fas fa-tag me-1"></i>{{ $betail->categorie->nom_categorie }}
                            </small>
                        @endif
                        <p class="card-text small">
                            <i class="fas fa-calendar-alt me-1 text-muted"></i>{{ $betail->age }} an(s)<br>
                            <i class="fas fa-weight-hanging me-1 text-muted"></i>{{ $betail->poids }} kg<br>
                            <i class="fas fa-map-marker-alt me-1 text-muted"></i>{{ $betail->origine }}
                        </p>
                        <p class="fw-bold text-success fs-6 mb-2">
                            {{ number_format($betail->prix, 0, ',', ' ') }} FCFA
                        </p>
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('betails.show', $betail->id_betail) }}"
                               class="btn btn-outline-success btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>Voir
                            </a>
                            @if($betail->disponibilite && $betail->quantite > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="betail_id" value="{{ $betail->id_betail }}">
                                    <input type="hidden" name="quantite" value="1">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-4x text-muted mb-3 d-block"></i>
                <h5 class="text-muted">Aucun bétail trouvé</h5>
                <a href="{{ route('home') }}" class="btn btn-outline-success mt-2">Voir tout le catalogue</a>
            </div>
        @endforelse
    </div>

</div>

<style>
.sagachap-hero {
    background: linear-gradient(135deg, #198754 0%, #0d6e42 50%, #0a5c38 100%);
    margin-top: -1.5rem;
}
.betail-card { transition: transform .2s, box-shadow .2s; }
.betail-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,.12) !important; }
</style>
@endsection
