@extends('components.layouts.app')

@section('title', 'Mon Panier — SagaChap')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold"><i class="fas fa-shopping-cart me-2 text-success"></i>Mon Panier</h2>

    @if($cartItems->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-5x text-muted mb-4 d-block"></i>
            <h4 class="text-muted">Votre panier est vide</h4>
            <p class="text-muted">Ajoutez des bétails depuis la page d'accueil.</p>
            <a href="{{ route('home') }}" class="btn btn-success btn-lg mt-2">
                <i class="fas fa-store me-2"></i>Voir les bétails
            </a>
        </div>
    @else
        <div class="row g-4">
            {{-- Articles --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Bétail</th>
                                    <th>Prix unitaire</th>
                                    <th style="width: 130px;">Quantité</th>
                                    <th>Sous-total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    @if($item->betail)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if($item->betail->photo)
                                                    <img src="{{ asset('storage/' . $item->betail->photo) }}"
                                                         alt="{{ $item->betail->race }}"
                                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width:60px;height:60px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="fw-bold mb-0">{{ $item->betail->race }}</p>
                                                    <small class="text-muted">{{ $item->betail->origine }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-success fw-semibold">
                                            {{ number_format($item->betail->prix, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('cart.update', $item->id) }}" class="d-flex gap-1">
                                                @csrf @method('PATCH')
                                                <input type="number" name="quantite"
                                                       value="{{ $item->quantite }}"
                                                       min="1" max="{{ $item->betail->quantite }}"
                                                       class="form-control form-control-sm" style="width: 65px;">
                                                <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="fw-bold">
                                            {{ number_format($item->betail->prix * $item->quantite, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Supprimer cet article ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Continuer mes achats
                    </a>
                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"
                                onclick="return confirm('Vider le panier ?')">
                            <i class="fas fa-trash me-1"></i>Vider le panier
                        </button>
                    </form>
                </div>
            </div>

            {{-- Récapitulatif --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                    <div class="card-header bg-success text-white fw-bold">
                        <i class="fas fa-receipt me-2"></i>Récapitulatif
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless small mb-0">
                            @foreach($cartItems as $item)
                                @if($item->betail)
                                <tr>
                                    <td>{{ $item->betail->race }} × {{ $item->quantite }}</td>
                                    <td class="text-end">{{ number_format($item->betail->prix * $item->quantite, 0, ',', ' ') }}</td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span class="text-success">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('cart.checkout') }}" class="btn btn-success w-100 btn-lg">
                            <i class="fas fa-credit-card me-2"></i>Passer la commande
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
