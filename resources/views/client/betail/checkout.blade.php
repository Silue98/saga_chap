@extends('components.layouts.app')

@section('title', 'Finaliser ma commande — SagaChap')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold"><i class="fas fa-credit-card me-2 text-success"></i>Finaliser ma commande</h2>

    <div class="row g-4">
        {{-- Formulaire --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="fas fa-user me-2"></i>Informations de livraison
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('order.place') }}">
                        @csrf

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                                       value="{{ old('nom', Auth::user()?->name ?? '') }}" required>
                                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
                                <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror"
                                       value="{{ old('prenom') }}" required>
                                @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Téléphone <span class="text-danger">*</span></label>
                                <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
                                       value="{{ old('telephone') }}" placeholder="ex: 07 00 00 00 00" required>
                                @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ville <span class="text-danger">*</span></label>
                                <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror"
                                       value="{{ old('ville') }}" required>
                                @error('ville')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Email
                                @guest <span class="text-muted small">(optionnel — pour recevoir la confirmation)</span> @endguest
                            </label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', Auth::user()?->email ?? '') }}"
                                   @auth readonly @endauth
                                   placeholder="votre@email.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Adresse complète <span class="text-danger">*</span></label>
                            <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror"
                                   value="{{ old('adresse') }}" placeholder="Quartier, rue, description..." required>
                            @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        </div>

                        <div class="alert alert-info mt-4 small">
                            <i class="fas fa-info-circle me-2"></i>
                            Paiement à la livraison. Notre équipe vous contactera pour confirmer votre commande.
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Confirmer la commande
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Retour au panier
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Récapitulatif commande --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-list me-2"></i>Votre commande ({{ $cartItems->count() }} article(s))
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($cartItems as $item)
                            @if($item->betail)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    @if($item->betail->photo)
                                        <img src="{{ asset('storage/' . $item->betail->photo) }}"
                                             style="width:45px;height:45px;object-fit:cover;border-radius:6px;">
                                    @endif
                                    <div>
                                        <p class="mb-0 fw-semibold small">{{ $item->betail->race }}</p>
                                        <small class="text-muted">× {{ $item->quantite }}</small>
                                    </div>
                                </div>
                                <span class="fw-bold text-success small">
                                    {{ number_format($item->betail->prix * $item->quantite, 0, ',', ' ') }} FCFA
                                </span>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total à payer</span>
                        <span class="text-success">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
