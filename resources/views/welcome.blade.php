@extends('components.layouts.app')

@section('title', 'Mon Application')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Nos Bétails Disponibles</h2>

    <div class="row">
        @forelse($betails as $betail)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    {{-- Image du bétail --}}
                    <img src="{{ asset('storage/' . $betail->photo) }}" class="card-img-top img-fluid" alt="Photo de {{ $betail->race }}" style="height: 180px; object-fit: cover;">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $betail->race }}</h5>
                        <p class="card-text">
                            <strong>Âge :</strong> {{ $betail->age }} an(s)<br>
                            <strong>Poids :</strong> {{ $betail->poids }} kg<br>
                            <strong>Prix :</strong> {{ number_format($betail->prix, 0, ',', ' ') }} FCFA<br>
                            <strong>Origine :</strong> {{ $betail->origine }}
                        </p>
                        <div class="mt-auto d-flex flex-wrap gap-2">
                            <a href="#" class="btn btn-primary btn-sm">Voir</a>
                            <a href="#" class="btn btn-success btn-sm">Ajouter au panier</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Aucun bétail disponible pour le moment.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection