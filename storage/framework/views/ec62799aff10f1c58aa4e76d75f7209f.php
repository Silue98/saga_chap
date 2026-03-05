<?php $__env->startSection('title', 'SagaChap — Vente de Bétail'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">

    
    <div class="p-4 mb-4 bg-success text-white rounded-3 shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-6 fw-bold"><i class="fas fa-cow me-2"></i>SagaChap</h1>
                <p class="lead mb-0">Achetez votre bétail en ligne — Moutons, Bœufs, Cabris et plus.</p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="fas fa-store" style="font-size: 5rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    
    <?php if(request('search') || request('categorie')): ?>
        <div class="alert alert-info d-flex align-items-center justify-content-between mb-3">
            <span>
                <i class="fas fa-filter me-2"></i>
                Résultats filtrés
                <?php if(request('search')): ?> pour "<strong><?php echo e(request('search')); ?></strong>"<?php endif; ?>
                <?php if(request('categorie')): ?>
                    — Catégorie : <strong><?php echo e($categories->firstWhere('id_categorie', request('categorie'))?->nom_categorie); ?></strong>
                <?php endif; ?>
                (<?php echo e($betails->count()); ?> résultat(s))
            </span>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times me-1"></i>Effacer les filtres
            </a>
        </div>
    <?php endif; ?>

    
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="<?php echo e(route('home')); ?>"
           class="btn btn-sm <?php echo e(!request('categorie') ? 'btn-success' : 'btn-outline-success'); ?>">
            Tous
        </a>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('home', ['categorie' => $cat->id_categorie])); ?>"
               class="btn btn-sm <?php echo e(request('categorie') == $cat->id_categorie ? 'btn-success' : 'btn-outline-success'); ?>">
                <?php echo e($cat->nom_categorie); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="row g-3">
        <?php $__empty_1 = true; $__currentLoopData = $betails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $betail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0">
                    <?php $imgMedia = $betail->images()->first(); ?>
                    <a href="<?php echo e(route('betails.show', $betail->id_betail)); ?>" style="display:block;overflow:hidden;border-radius:8px 8px 0 0;">
                    <?php if($imgMedia): ?>
                        <img src="<?php echo e(asset('storage/' . $imgMedia->chemin)); ?>"
                             class="card-img-top"
                             style="height:200px;object-fit:cover;transition:transform .3s;"
                             onmouseover="this.style.transform='scale(1.04)'"
                             onmouseout="this.style.transform='scale(1)'"
                             alt="<?php echo e($betail->race); ?>">
                    <?php elseif($betail->photo): ?>
                        <img src="<?php echo e(asset('storage/' . $betail->photo)); ?>"
                             class="card-img-top"
                             style="height:200px;object-fit:cover;transition:transform .3s;"
                             onmouseover="this.style.transform='scale(1.04)'"
                             onmouseout="this.style.transform='scale(1)'"
                             alt="Photo de <?php echo e($betail->race); ?>">
                    <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                            <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0"><?php echo e($betail->race); ?></h5>
                            <span class="badge bg-<?php echo e($betail->disponibilite ? 'success' : 'danger'); ?>">
                                <?php echo e($betail->disponibilite ? 'Dispo' : 'Indispo'); ?>

                            </span>
                        </div>
                        <?php if($betail->categorie): ?>
                            <small class="text-muted mb-2">
                                <i class="fas fa-tag me-1"></i><?php echo e($betail->categorie->nom_categorie); ?>

                            </small>
                        <?php endif; ?>
                        <p class="card-text small">
                            <i class="fas fa-calendar-alt me-1 text-muted"></i><?php echo e($betail->age); ?> an(s)<br>
                            <i class="fas fa-weight-hanging me-1 text-muted"></i><?php echo e($betail->poids); ?> kg<br>
                            <i class="fas fa-map-marker-alt me-1 text-muted"></i><?php echo e($betail->origine); ?>

                        </p>
                        <p class="fw-bold text-success fs-6 mb-2">
                            <?php echo e(number_format($betail->prix, 0, ',', ' ')); ?> FCFA
                        </p>
                        <div class="mt-auto d-flex gap-2">
                            <a href="<?php echo e(route('betails.show', $betail->id_betail)); ?>"
                               class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>Voir
                            </a>
                            <?php if($betail->disponibilite): ?>
                                <button type="button"
                                        onclick="addToCartLivewire(<?php echo e($betail->id_betail); ?>)"
                                        class="btn btn-success btn-sm flex-fill">
                                    <i class="fas fa-cart-plus me-1"></i>Panier
                                </button>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm flex-fill" disabled>Indisponible</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center py-5">
                    <i class="fas fa-search fa-3x mb-3 text-muted d-block"></i>
                    <h5>Aucun bétail trouvé</h5>
                    <p class="mb-0">Essayez d'autres filtres ou revenez plus tard.</p>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-warning mt-3">Voir tous les bétails</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Own project\saga_chap\resources\views/welcome.blade.php ENDPATH**/ ?>