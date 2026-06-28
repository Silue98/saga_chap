<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SagaChap — Le bétail de qualité, à portée de clic')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @livewireStyles
    <style>
        .cart-wrapper { position: relative; display: inline-block; }
        .cart-wrapper .cart-badge {
            position: absolute;
            top: -6px; right: -10px;
            font-size: 0.65rem;
            min-width: 18px; height: 18px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 999px;
            padding: 0 4px;
        }
        .navbar-brand .brand-slogan {
            font-size: 0.65rem;
            color: #6c757d;
            display: block;
            line-height: 1;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

{{-- Unique instance Livewire cart-counter --}}
<livewire:cart-counter />

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container px-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="{{ route('home') }}">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" style="width: 38px; height: 38px; object-fit: cover; border-radius:50%;">
                <div>
                    <span class="fw-bold text-success" style="font-size:1.1rem;">SÂGACHAP</span>
                    <span class="brand-slogan">Le bétail de qualité, à portée de clic</span>
                </div>
            </div>
        </a>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>Accueil
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-layer-group me-1"></i>Catégories
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="fas fa-border-all me-2"></i>Toutes les catégories
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach ($categories as $categorie)
                            <li>
                                <a class="dropdown-item {{ request('categorie') == $categorie->id_categorie ? 'active' : '' }}"
                                   href="{{ route('home', ['categorie' => $categorie->id_categorie]) }}">
                                    {{ $categorie->nom_categorie }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            {{-- Recherche desktop --}}
            <form class="d-none d-lg-flex mx-auto" style="max-width: 400px;" method="GET" action="{{ route('home') }}">
                <div class="input-group">
                    <input class="form-control" type="search" name="search"
                           placeholder="Rechercher une race, origine..."
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <ul class="navbar-nav mb-2 mb-lg-0 ms-2">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="fas fa-list-alt me-2"></i>Mes commandes
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('settings.profile') }}">
                                    <i class="fas fa-cog me-2"></i>Paramètres
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Inscription
                        </a>
                    </li>
                @endauth

                {{-- Panier desktop --}}
                <li class="nav-item d-none d-lg-flex align-items-center ms-1">
                    <a href="{{ route('cart.index') }}" class="nav-link cart-wrapper">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span class="cart-badge badge bg-danger" id="nav-cart-badge">0</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Mobile : recherche + panier --}}
        <div class="d-flex d-lg-none align-items-center gap-2">
            <button class="btn btn-link text-dark p-1" type="button"
                    data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                <i class="fas fa-search"></i>
            </button>
            <a href="{{ route('cart.index') }}" class="btn btn-link text-dark p-1 cart-wrapper">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge badge bg-danger" id="nav-cart-badge-mobile">0</span>
            </a>
        </div>
    </div>
</nav>

{{-- Recherche mobile --}}
<div class="collapse" id="searchCollapse">
    <div class="container py-2">
        <form method="GET" action="{{ route('home') }}">
            <div class="input-group">
                <input class="form-control" type="search" name="search"
                       placeholder="Rechercher..." value="{{ request('search') }}">
                <button class="btn btn-success" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Flash messages --}}
@if(session('cart_success'))
    <div class="alert alert-success alert-dismissible fade show m-2 mb-0" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('cart_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-2 mb-0" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('order_success'))
    <div class="alert alert-success alert-dismissible fade show m-2 mb-0" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('order_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<main class="py-4 flex-grow-1">
    @yield('content')
</main>

<footer class="bg-white border-top py-4 mt-4">
    <div class="container">
        <div class="row align-items-center g-3">

            <div class="col-md-4 text-center text-md-start">
                <div class="d-flex align-items-center gap-2 mb-1 justify-content-center justify-content-md-start">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="SagaChap"
                         style="width:32px;height:32px;object-fit:cover;border-radius:50%;">
                    <strong class="text-success">SÂGACHAP</strong>
                </div>
                <p class="mb-1 small text-muted fst-italic">🐄 Le bétail de qualité, à portée de clic</p>
                <p class="mb-0 text-muted" style="font-size:0.7rem;">"Même ce que tu penses pas trouver, nous on te livre ça."</p>
                <p class="mb-0 text-muted small mt-1">&copy; {{ date('Y') }} Tous droits réservés.</p>
            </div>

            <div class="col-md-4 text-center">
                <a href="{{ route('home') }}" class="text-muted text-decoration-none small me-3">Accueil</a>
                <a href="{{ route('cart.index') }}" class="text-muted text-decoration-none small me-3">Panier</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="text-muted text-decoration-none small">Mes commandes</a>
                @endauth
            </div>

           <div class="col-md-4 text-center text-md-end" style="font-size:0.425rem;">
    <p class="mb-1 fw-semibold">
        <i class="fas fa-code text-success me-1"></i>
        Développé par SS — Silué Samuel

    <p class="mb-0">
        <a href="tel:+2250788718510" class="text-success text-decoration-none me-3">
            <i class="fas fa-phone me-1"></i>
            +225 07 88 71 85 10
        </a>

        <a href="tel:+2250586671113" class="text-success text-decoration-none">
            <i class="fas fa-phone me-1"></i>
            +225 05 86 67 11 13
        </a>
    </p>
</div>

        </div>
    </div>
</footer>

@livewireScripts

<script>
    (function() {
        const initialCount = parseInt("{{ \App\Models\Cart::where(function($q){ $s=session()->getId(); $u=auth()->check()?auth()->id():null; if($u){$q->where('user_id',$u)->orWhere('session_id',$s);}else{$q->where('session_id',$s);} })->sum('quantite') ?? 0 }}");
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('#nav-cart-badge, #nav-cart-badge-mobile').forEach(b => {
                b.textContent = initialCount;
                b.style.display = initialCount > 0 ? 'flex' : 'none';
            });
        });
    })();

    function addToCartLivewire(betailId, quantity = 1) {
        const el = document.querySelector('[wire\\:id]');
        if (el) {
            const component = Livewire.find(el.getAttribute('wire:id'));
            if (component) {
                component.call('addToCart', betailId, quantity);
                return;
            }
        }
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("cart.add") }}';
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="betail_id" value="${betailId}">
            <input type="hidden" name="quantite" value="${quantity}">
        `;
        document.body.appendChild(form);
        form.submit();
    }

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('cartCountUpdated', ({ count }) => {
            document.querySelectorAll('#nav-cart-badge, #nav-cart-badge-mobile').forEach(b => {
                b.textContent = count;
                b.style.display = count > 0 ? 'flex' : 'none';
            });
        });
    });
</script>

</body>
</html>
