@extends('components.layouts.app')
@section('title', 'Détails du Bétail')
@section('content') 
<div class="container mt-4">
    <h2 class="mb-3">{{ $betail->race }}</h2>

    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $betail->photo) }}" class="img-fluid" alt="Photo de {{ $betail->race }}">
        </div>
        <div class="col-md-6">
            <p><strong>Âge :</strong> {{ $betail->age }} an(s)</p>
            <p><strong>Poids :</strong> {{ $betail->poids }} kg</p>
            <p><strong>Prix :</strong> {{ number_format($betail->prix, 0, ',', ' ') }} FCFA</p>
            <p><strong>Origine :</strong> {{ $betail->origine }}</p>

            <a href="#" class="btn btn-success">Ajouter au panier</a>
        </div>
    </div>
</div>
@endsection