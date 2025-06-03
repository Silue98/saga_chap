@extends('components.layouts.app')

@section('title', 'Détails du Bétail')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                {{-- Image du bétail --}}
                <img src="{{ asset('storage/' . $betail->photo) }}" alt="Photo de {{ $betail->race }}" class="card-img-top img-fluid rounded-top" style="max-height: 350px; object-fit: cover;">

                <div class="card-body p-4">
                    <h3 class="card-title text-center text-primary mb-4">{{ $betail->race }}</h3>

                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item"><strong>Âge :</strong> {{ $betail->age }} an(s)</li>
                        <li class="list-group-item"><strong>Poids :</strong> {{ $betail->poids }} kg</li>
                        <li class="list-group-item"><strong>Prix :</strong> <span class="text-success fw-bold">{{ number_format($betail->prix, 0, ',', ' ') }} FCFA</span></li>
                        <li class="list-group-item"><strong>Origine :</strong> {{ $betail->origine }}</li>
                    </ul>

                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-success">Ajouter au panier</a>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Retour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
