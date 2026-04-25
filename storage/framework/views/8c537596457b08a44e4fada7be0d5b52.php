<?php $__env->startSection('title', 'Commande confirmée — SagaChap'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">

                    
                    <div class="text-center mb-4">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width:90px;height:90px;">
                            <i class="fas fa-check text-white" style="font-size:2.8rem;"></i>
                        </div>
                        <h3 class="text-success fw-bold mb-1">Commande confirmée !</h3>
                        <p class="text-muted">Numéro de commande : <strong class="text-dark">#<?php echo e($commande->id); ?></strong></p>
                    </div>

                    
                    <div class="alert alert-success-subtle border border-success-subtle mb-4">
                        <p class="mb-1">
                            <i class="fas fa-user text-success me-2"></i>
                            Merci <strong><?php echo e($commande->prenom); ?> <?php echo e($commande->nom); ?></strong>, votre commande a bien été enregistrée.
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-phone text-success me-2"></i>
                            Notre équipe vous contactera au <strong><?php echo e($commande->telephone); ?></strong> pour confirmer la livraison.
                        </p>
                    </div>

                    
                    <div class="text-center mb-4 p-3 bg-success rounded text-white">
                        <p class="mb-0 fst-italic">"Même ce que tu penses pas trouver, nous on te livre ça."</p>
                        <small class="fw-bold">— SÂGACHAP</small>
                    </div>

                    
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="fas fa-receipt me-2 text-success"></i>Récapitulatif</h6>
                            <?php $__currentLoopData = $commande->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($item->betail): ?>
                                <div class="d-flex justify-content-between small mb-2 align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <?php $img = $item->betail->images()->first(); ?>
                                        <?php if($img): ?>
                                            <img src="<?php echo e(asset('storage/' . $img->chemin)); ?>"
                                                 style="width:36px;height:36px;object-fit:cover;border-radius:4px;">
                                        <?php elseif($item->betail->photo): ?>
                                            <img src="<?php echo e(asset('storage/' . $item->betail->photo)); ?>"
                                                 style="width:36px;height:36px;object-fit:cover;border-radius:4px;">
                                        <?php endif; ?>
                                        <span><?php echo e($item->betail->race); ?> × <?php echo e($item->quantite); ?></span>
                                    </div>
                                    <span class="fw-semibold"><?php echo e(number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ')); ?> FCFA</span>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total payé à la livraison</span>
                                <span class="text-success fs-5"><?php echo e(number_format($commande->montant_total, 0, ',', ' ')); ?> FCFA</span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="small text-muted mb-4">
                        <strong><i class="fas fa-map-marker-alt text-success me-1"></i>Adresse de livraison :</strong><br>
                        <?php echo e($commande->adresse); ?>, <?php echo e($commande->ville); ?>

                    </div>

                    
                    <div class="d-flex flex-column gap-2">
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-success btn-lg">
                            <i class="fas fa-store me-2"></i>Continuer mes achats
                        </a>
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-success">
                                <i class="fas fa-list-alt me-2"></i>Voir mes commandes
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-user-plus me-2"></i>Créer un compte pour suivre mes commandes
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Own project\saga_chap\resources\views/client/cart/confirmation.blade.php ENDPATH**/ ?>