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
                         style="height:380px;object-fit:cover;">
                @elseif($betail->photo)
                    <img src="{{ asset('storage/' . $betail->photo) }}"
                         alt="{{ $betail->race }}"
                         class="w-100"
                         style="height:380px;object-fit:cover;">
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
                             onclick="document.getElementById('main-photo').src = this.src"
                             class="rounded border"
                             style="width:72px;height:72px;object-fit:cover;cursor:pointer;transition:opacity .2s;"
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
                    <video controls class="w-100 rounded border" style="max-height:280px;background:#000;">
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
                    <video controls class="w-100 rounded border" style="max-height:280px;background:#000;">
                        <source src="{{ asset('storage/' . $betail->video) }}" type="video/mp4">
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
        </div>
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
                                 style="height:140px;object-fit:cover;"
                                 alt="{{ $s->race }}">
                        @elseif($s->photo)
                            <img src="{{ asset('storage/' . $s->photo) }}"
                                 class="card-img-top"
                                 style="height:140px;object-fit:cover;"
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
