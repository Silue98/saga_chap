@extends('components.layouts.app')

@section('title', 'Commande confirmée — SagaChap')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-check text-white" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="text-success fw-bold mb-2">Commande confirmée !</h3>
                    <p class="text-muted mb-1">Numéro de commande : <strong>#{{ $commande->id }}</strong></p>
                    <p class="text-muted mb-4">Merci <strong>{{ $commande->prenom }} {{ $commande->nom }}</strong>, votre commande a bien été enregistrée.</p>

                    <div class="alert alert-info text-start">
                        <i class="fas fa-phone me-2"></i>Notre équipe vous contactera au
                        <strong>{{ $commande->telephone }}</strong> pour confirmer la livraison.
                    </div>

                    <div class="card bg-light border-0 text-start mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Récapitulatif</h6>
                            @foreach($commande->items as $item)
                                @if($item->betail)
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>{{ $item->betail->race }} × {{ $item->quantite }}</span>
                                    <span>{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA</span>
                                </div>
                                @endif
                            @endforeach
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span class="text-success">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('home') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-store me-2"></i>Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
