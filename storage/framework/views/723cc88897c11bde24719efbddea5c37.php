<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'SagaChap'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="<?php echo e(asset('images/logo.jpeg')); ?>" type="image/x-icon">
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

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
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">


<?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('cart-counter', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2860400159-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container px-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
            <img src="<?php echo e(asset('images/logo.jpeg')); ?>" alt="Logo" style="width: 40px; height: 40px; object-fit: cover; border-radius:50%;">
            <span class="ms-2 fw-bold text-success">SagaChap</span>
        </a>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('home')); ?>">
                        <i class="fas fa-home me-1"></i>Accueil
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-layer-group me-1"></i>Catégories
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('home')); ?>">
                                <i class="fas fa-border-all me-2"></i>Toutes les catégories
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a class="dropdown-item <?php echo e(request('categorie') == $categorie->id_categorie ? 'active' : ''); ?>"
                                   href="<?php echo e(route('home', ['categorie' => $categorie->id_categorie])); ?>">
                                    <?php echo e($categorie->nom_categorie); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            </ul>

            
            <form class="d-none d-lg-flex mx-auto" style="max-width: 400px;" method="GET" action="<?php echo e(route('home')); ?>">
                <div class="input-group">
                    <input class="form-control" type="search" name="search"
                           placeholder="Rechercher une race, origine..."
                           value="<?php echo e(request('search')); ?>">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <ul class="navbar-nav mb-2 mb-lg-0 ms-2">
                <?php if(auth()->guard()->check()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i><?php echo e(Auth::user()->name); ?>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">
                                    <i class="fas fa-list-alt me-2"></i>Mes commandes
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('settings.profile')); ?>">
                                    <i class="fas fa-cog me-2"></i>Paramètres
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('login')); ?>">
                            <i class="fas fa-sign-in-alt me-1"></i>Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('register')); ?>">
                            <i class="fas fa-user-plus me-1"></i>Inscription
                        </a>
                    </li>
                <?php endif; ?>

                
                <li class="nav-item d-none d-lg-flex align-items-center ms-1">
                    <a href="<?php echo e(route('cart.index')); ?>" class="nav-link cart-wrapper">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span class="cart-badge badge bg-danger" id="nav-cart-badge">0</span>
                    </a>
                </li>
            </ul>
        </div>

        
        <div class="d-flex d-lg-none align-items-center gap-2">
            <button class="btn btn-link text-dark p-1" type="button"
                    data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                <i class="fas fa-search"></i>
            </button>
            <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-link text-dark p-1 cart-wrapper">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge badge bg-danger" id="nav-cart-badge-mobile">0</span>
            </a>
        </div>
    </div>
</nav>


<div class="collapse" id="searchCollapse">
    <div class="container py-2">
        <form method="GET" action="<?php echo e(route('home')); ?>">
            <div class="input-group">
                <input class="form-control" type="search" name="search"
                       placeholder="Rechercher..." value="<?php echo e(request('search')); ?>">
                <button class="btn btn-success" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>


<?php if(session('cart_success')): ?>
    <div class="alert alert-success alert-dismissible fade show m-2 mb-0" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo e(session('cart_success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show m-2 mb-0" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if(session('order_success')): ?>
    <div class="alert alert-success alert-dismissible fade show m-2 mb-0" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo e(session('order_success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<main class="py-4 flex-grow-1">
    <div class="container px-3">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</main>

<footer class="bg-white border-top py-4 mt-4">
    <div class="container">
        <div class="row align-items-center g-3">

            <div class="col-md-4 text-center text-md-start">
                <p class="mb-1"><strong class="text-success">SagaChap</strong> — Vente de bétail en ligne</p>
                <p class="mb-0 text-muted small">&copy; <?php echo e(date('Y')); ?> Tous droits réservés.</p>
            </div>

            <div class="col-md-4 text-center">
                <a href="<?php echo e(route('home')); ?>" class="text-muted text-decoration-none small me-3">Accueil</a>
                <a href="<?php echo e(route('cart.index')); ?>" class="text-muted text-decoration-none small me-3">Panier</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('orders.index')); ?>" class="text-muted text-decoration-none small">Mes commandes</a>
                <?php endif; ?>
            </div>

            <div class="col-md-4 text-center text-md-end">
                <p class="mb-1 small fw-semibold">
                    <i class="fas fa-code text-success me-1"></i>Développé par <strong>SS — Silué Samuel</strong>
                </p>
                <p class="mb-0 small">
                    <a href="tel:+2250788718510" class="text-success text-decoration-none me-3">
                        <i class="fas fa-phone me-1"></i>+225 07 88 71 85 10
                    </a>
                    <a href="tel:+2250586671113" class="text-success text-decoration-none">
                        <i class="fas fa-phone me-1"></i>+225 05 86 67 11 13
                    </a>
                </p>
            </div>

        </div>
    </div>
</footer>

<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


<script>
    // Badge initialisé côté serveur dès le chargement de la page
    (function() {
        const initialCount = parseInt("<?php echo e(\App\Models\Cart::where(function($q){ $s=session()->getId(); $u=auth()->check()?auth()->id():null; if($u){$q->where('user_id',$u)->orWhere('session_id',$s);}else{$q->where('session_id',$s);} })->sum('quantite') ?? 0); ?>");
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('#nav-cart-badge, #nav-cart-badge-mobile').forEach(b => {
                b.textContent = initialCount;
                b.style.display = initialCount > 0 ? 'flex' : 'none';
            });
        });
    })();

    // Ajouter au panier via Livewire
    function addToCartLivewire(betailId, quantity = 1) {
        const el = document.querySelector('[wire\\:id]');
        if (el) {
            const component = Livewire.find(el.getAttribute('wire:id'));
            if (component) {
                component.call('addToCart', betailId, quantity);
                return;
            }
        }
        // Fallback POST classique
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo e(route("cart.add")); ?>';
        form.innerHTML = `
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <input type="hidden" name="betail_id" value="${betailId}">
            <input type="hidden" name="quantite" value="${quantity}">
        `;
        document.body.appendChild(form);
        form.submit();
    }

    // Mise à jour du badge via événement Livewire
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
<?php /**PATH D:\Own project\saga_chap\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>