@extends('components.layouts.app')

@section('title', 'Commande #' . $commande->id . ' — SagaChap')

@section('content')
<div class="container mt-4">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Mes commandes</a></li>
            <li class="breadcrumb-item active">Commande #{{ $commande->id }}</li>
        </ol>
    </nav>

    @php
        $badges = ['en_attente' => 'warning', 'confirmee' => 'success', 'livree' => 'primary', 'annulee' => 'danger'];
        $labels = ['en_attente' => 'En attente', 'confirmee' => 'Confirmée', 'livree' => 'Livrée', 'annulee' => 'Annulée'];
    @endphp

    <div class="row g-4">

        {{-- Détail articles --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-shopping-cart me-2 text-success"></i>
                        Commande #{{ $commande->id }}
                    </h5>
                    <span class="badge bg-{{ $badges[$commande->statut] ?? 'secondary' }} fs-6">
                        {{ $labels[$commande->statut] ?? $commande->statut }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Bétail</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commande->items as $item)
                                @if($item->betail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @php $ordImg = $item->betail->images()->first(); @endphp
                                    @if($ordImg)
                                        <img src="{{ asset('storage/' . $ordImg->chemin) }}"
                                             style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                                    @elseif($item->betail->photo)
                                                <img src="{{ asset('storage/' . $item->betail->photo) }}"
                                                     style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                     style="width:50px;height:50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="fw-semibold mb-0">{{ $item->betail->race }}</p>
                                                <small class="text-muted">{{ $item->betail->origine }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ $item->quantite }}</td>
                                    <td class="fw-bold text-success">
                                        {{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="fw-bold text-end">Total</td>
                                <td class="fw-bold text-success fs-5">
                                    {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Suivi statut --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-truck me-2 text-success"></i>Suivi de commande</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        @foreach(['en_attente' => 'En attente', 'confirmee' => 'Confirmée', 'livree' => 'Livrée'] as $step => $label)
                            @php
                                $steps = ['en_attente', 'confirmee', 'livree'];
                                $currentIndex = array_search($commande->statut, $steps);
                                $stepIndex = array_search($step, $steps);
                                $isDone = $currentIndex !== false && $stepIndex <= $currentIndex;
                                $isActive = $commande->statut === $step;
                            @endphp
                            <div class="text-center flex-fill">
                                <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-1
                                    {{ $isDone ? 'bg-success text-white' : 'bg-light text-muted' }}"
                                    style="width:36px;height:36px;font-size:14px;">
                                    @if($isDone) <i class="fas fa-check"></i>
                                    @else <i class="fas fa-clock"></i>
                                    @endif
                                </div>
                                <small class="{{ $isActive ? 'fw-bold text-success' : 'text-muted' }}">{{ $label }}</small>
                            </div>
                            @if(!$loop->last)
                                <div class="flex-fill border-top border-2 mb-4
                                    {{ $isDone && $stepIndex < $currentIndex ? 'border-success' : 'border-light' }}">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if($commande->statut === 'annulee')
                        <div class="alert alert-danger mt-3 mb-0">
                            <i class="fas fa-times-circle me-2"></i>Cette commande a été annulée.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Infos livraison --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white fw-bold">
                    <i class="fas fa-map-marker-alt me-2 text-success"></i>Livraison
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $commande->prenom }} {{ $commande->nom }}</strong></p>
                    <p class="mb-1 text-muted"><i class="fas fa-phone me-2"></i>{{ $commande->telephone }}</p>
                    <p class="mb-1 text-muted"><i class="fas fa-city me-2"></i>{{ $commande->ville }}</p>
                    <p class="mb-0 text-muted"><i class="fas fa-home me-2"></i>{{ $commande->adresse }}</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-1">Date de commande</p>
                    <p class="fw-bold mb-0">{{ $commande->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100 mt-3">
                <i class="fas fa-arrow-left me-1"></i>Retour à mes commandes
            </a>
        </div>

    </div>
</div>
@endsection
