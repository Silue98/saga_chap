<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Application')</title>

    {{-- Assets compilés avec Vite --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Font Awesome pour les icônes --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
</head>
<body class="bg-light">

    {{-- Barre de navigation --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container px-3">
          {{-- Bouton pour affichage mobile --}}
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

            {{-- Logo --}}
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" style="width: 40px; height: 40px; object-fit: cover;">
                <span class="ms-2 fw-bold">SagaChap</span>
            </a>

            {{-- Contenu navbar --}}
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home me-1"></i>Accueil</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-layer-group me-1"></i>Catégories
                        </a>
                        {{--d--}}
                        <ul class="dropdown-menu">
                            @foreach ($categories as $categorie)
                                <li><a class="dropdown-item" href="#">{{ $categorie->nom_categorie }}</a></li>
                            @endforeach

                        </ul>
                    </li>
                </ul>

                {{-- Barre de recherche (centrée sur desktop) --}}
                <form class="d-none d-lg-flex mx-auto" style="max-width: 400px;" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Rechercher..." aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    {{-- Compte utilisateur --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>Compte
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-history me-2"></i>Historique</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                        </ul>
                    </li>

                    {{-- Panier (visible en desktop) --}}
                    <li class="nav-item d-none d-lg-block">
                        <a href="#" class="nav-link position-relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Recherche + panier mobile --}}
            <div class="d-flex d-lg-none align-items-center">
                <button class="btn btn-link text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                    <i class="fas fa-search"></i>
                </button>
                <a href="#" class="btn btn-link text-dark position-relative ms-2">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                </a>
            </div>
        </div>
    </nav>

    {{-- Barre de recherche mobile --}}
    <div class="collapse" id="searchCollapse">
        <div class="container py-2">
            <form role="search"> 
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Rechercher..." aria-label="Search">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Contenu principal --}}
    <main class="py-4">
        <div class="container px-3">
            @yield('content')
        </div>
    </main>

</body>
</html>