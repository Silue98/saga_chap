@extends('components.layouts.app')

@section('title', 'SagaChap — Vente de Bétail')

@section('content')
<div class="container mt-4">

    {{-- Hero --}}
    <div class="p-4 mb-4 bg-success text-white rounded-3 shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-6 fw-bold"><i class="fas fa-cow me-2"></i>SagaChap</h1>
                <p class="lead mb-0">Achetez votre bétail en ligne — Moutons, Bœufs, Cabris et plus.</p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="fas fa-store" style="font-size: 5rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

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
            Tous
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
                <div class="card h-100 shadow-sm border-0">
                    @php $imgMedia = $betail->images()->first(); @endphp
                    <a href="{{ route('betails.show', $betail->id_betail) }}" style="display:block;overflow:hidden;border-radius:8px 8px 0 0;">
                    @if($imgMedia)
                        <img src="{{ asset('storage/' . $imgMedia->chemin) }}"
                             class="card-img-top"
                             style="height:200px;object-fit:cover;transition:transform .3s;"
                             onmouseover="this.style.transform='scale(1.04)'"
                             onmouseout="this.style.transform='scale(1)'"
                             alt="{{ $betail->race }}">
                    @elseif($betail->photo)
                        <img src="{{ asset('storage/' . $betail->photo) }}"
                             class="card-img-top"
                             style="height:200px;object-fit:cover;transition:transform .3s;"
                             onmouseover="this.style.transform='scale(1.04)'"
                             onmouseout="this.style.transform='scale(1)'"
                             alt="Photo de {{ $betail->race }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                            <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    </a>
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
                               class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>Voir
                            </a>
                            @if($betail->disponibilite)
                                <button type="button"
                                        onclick="addToCartLivewire({{ $betail->id_betail }})"
                                        class="btn btn-success btn-sm flex-fill">
                                    <i class="fas fa-cart-plus me-1"></i>Panier
                                </button>
                            @else
                                <button class="btn btn-secondary btn-sm flex-fill" disabled>Indisponible</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center py-5">
                    <i class="fas fa-search fa-3x mb-3 text-muted d-block"></i>
                    <h5>Aucun bétail trouvé</h5>
                    <p class="mb-0">Essayez d'autres filtres ou revenez plus tard.</p>
                    <a href="{{ route('home') }}" class="btn btn-outline-warning mt-3">Voir tous les bétails</a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection