<?php $__env->startSection('title', 'Finaliser ma commande — SagaChap'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">

    
    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
        <h2 class="fw-bold mb-0"><i class="fas fa-credit-card me-2 text-success"></i>Finaliser ma commande</h2>
        <?php if(auth()->guard()->guest()): ?>
            <span class="badge bg-success fs-6 px-3 py-2">
                <i class="fas fa-check me-1"></i>Sans inscription requise
            </span>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="fas fa-user me-2"></i>Informations de livraison
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('order.place')); ?>">
                        <?php echo csrf_field(); ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="nom"
                                       class="form-control <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('nom', Auth::user()?->name ?? '')); ?>" required
                                       placeholder="Votre nom">
                                <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
                                <input type="text" name="prenom"
                                       class="form-control <?php $__errorArgs = ['prenom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('prenom')); ?>" required
                                       placeholder="Votre prénom">
                                <?php $__errorArgs = ['prenom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Téléphone <span class="text-danger">*</span></label>
                                <input type="tel" name="telephone"
                                       class="form-control <?php $__errorArgs = ['telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('telephone')); ?>"
                                       placeholder="ex: 07 00 00 00 00" required>
                                <?php $__errorArgs = ['telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ville <span class="text-danger">*</span></label>
                                <input type="text" name="ville"
                                       class="form-control <?php $__errorArgs = ['ville'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('ville')); ?>"
                                       placeholder="Abidjan, Bouaké..." required>
                                <?php $__errorArgs = ['ville'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Email
                                    <?php if(auth()->guard()->guest()): ?>
                                        <span class="text-muted small">(optionnel — pour recevoir la confirmation)</span>
                                    <?php endif; ?>
                                </label>
                                <input type="email" name="email"
                                       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('email', Auth::user()?->email ?? '')); ?>"
                                       <?php if(auth()->guard()->check()): ?> readonly <?php endif; ?>
                                       placeholder="votre@email.com">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Adresse complète <span class="text-danger">*</span></label>
                                <input type="text" name="adresse"
                                       class="form-control <?php $__errorArgs = ['adresse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('adresse')); ?>"
                                       placeholder="Quartier, rue, repère..." required>
                                <?php $__errorArgs = ['adresse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4 small">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Paiement à la livraison.</strong> Notre équipe vous contactera au numéro fourni pour confirmer et planifier la livraison.
                        </div>

                        <?php if(auth()->guard()->guest()): ?>
                            <div class="alert alert-success-subtle border border-success-subtle mt-2 small">
                                <i class="fas fa-user-check text-success me-2"></i>
                                Vous commandez en tant qu'invité. Créez un compte pour suivre vos commandes ultérieurement.
                                <a href="<?php echo e(route('register')); ?>" class="text-success">S'inscrire gratuitement</a>
                            </div>
                        <?php endif; ?>

                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Confirmer la commande
                            </button>
                            <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Retour au panier
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-list me-2"></i>Votre commande (<?php echo e($cartItems->count()); ?> article(s))
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item->betail): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <?php $img = $item->betail->images()->first(); ?>
                                    <?php if($img): ?>
                                        <img src="<?php echo e(asset('storage/' . $img->chemin)); ?>"
                                             style="width:48px;height:48px;object-fit:contain;border-radius:6px;">
                                    <?php elseif($item->betail->photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $item->betail->photo)); ?>"
                                             style="width:48px;height:48px;object-fit:contain;border-radius:6px;">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <p class="mb-0 fw-semibold small"><?php echo e($item->betail->race); ?></p>
                                        <small class="text-muted">× <?php echo e($item->quantite); ?></small>
                                    </div>
                                </div>
                                <span class="fw-bold text-success small">
                                    <?php echo e(number_format($item->betail->prix * $item->quantite, 0, ',', ' ')); ?> FCFA
                                </span>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total à payer</span>
                        <span class="text-success"><?php echo e(number_format($total, 0, ',', ' ')); ?> FCFA</span>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-hand-holding-usd me-1"></i>Paiement à la livraison
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Own project\saga_chap\resources\views/client/betail/checkout.blade.php ENDPATH**/ ?>