@extends('components.layouts.app')

@section('title', 'Mes commandes — SagaChap')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="fas fa-list-alt me-2 text-success"></i>Mes commandes
        </h2>
        <a href="{{ route('home') }}" class="btn btn-outline-success">
            <i class="fas fa-store me-1"></i>Continuer mes achats
        </a>
    </div>

    @if($commandes->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-5x text-muted mb-4 d-block"></i>
            <h4 class="text-muted">Vous n'avez pas encore de commande</h4>
            <a href="{{ route('home') }}" class="btn btn-success mt-3">
                <i class="fas fa-store me-2"></i>Voir les bétails
            </a>
        </div>
    @else
        <div class="row g-3">
            @foreach($commandes as $commande)
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">

                                {{-- Numéro et date --}}
                                <div class="col-md-2">
                                    <p class="text-muted small mb-0">Commande</p>
                                    <p class="fw-bold mb-0">#{{ $commande->id }}</p>
                                    <small class="text-muted">{{ $commande->created_at->format('d/m/Y') }}</small>
                                </div>

                                {{-- Articles --}}
                                <div class="col-md-4">
                                    <p class="text-muted small mb-1">Articles</p>
                                    <div class="d-flex gap-1 flex-wrap">
                                        @foreach($commande->items->take(3) as $item)
                                            @if($item->betail)
                                                <span class="badge bg-light text-dark border">
                                                    {{ $item->betail->race }} ×{{ $item->quantite }}
                                                </span>
                                            @endif
                                        @endforeach
                                        @if($commande->items->count() > 3)
                                            <span class="badge bg-light text-muted border">
                                                +{{ $commande->items->count() - 3 }} autre(s)
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Total --}}
                                <div class="col-md-2">
                                    <p class="text-muted small mb-0">Total</p>
                                    <p class="fw-bold text-success mb-0">
                                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                                    </p>
                                </div>

                                {{-- Statut --}}
                                <div class="col-md-2">
                                    @php
                                        $badges = [
                                            'en_attente' => 'warning',
                                            'confirmee'  => 'success',
                                            'livree'     => 'primary',
                                            'annulee'    => 'danger',
                                        ];
                                        $labels = [
                                            'en_attente' => 'En attente',
                                            'confirmee'  => 'Confirmée',
                                            'livree'     => 'Livrée',
                                            'annulee'    => 'Annulée',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $badges[$commande->statut] ?? 'secondary' }} fs-6">
                                        {{ $labels[$commande->statut] ?? $commande->statut }}
                                    </span>
                                </div>

                                {{-- Action --}}
                                <div class="col-md-2 text-end">
                                    <a href="{{ route('orders.show', $commande->id) }}"
                                       class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-eye me-1"></i>Détail
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
