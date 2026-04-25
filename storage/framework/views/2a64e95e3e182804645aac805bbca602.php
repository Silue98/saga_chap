<?php $__env->startSection('title', $betail->race . ' — SagaChap'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">

    
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Accueil</a></li>
            <?php if($betail->categorie): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('home', ['categorie' => $betail->categorie->id_categorie])); ?>">
                        <?php echo e($betail->categorie->nom_categorie); ?>

                    </a>
                </li>
            <?php endif; ?>
            <li class="breadcrumb-item active"><?php echo e($betail->race); ?></li>
        </ol>
    </nav>

    <div class="row g-4">

        
        <div class="col-lg-6">

            
            <div class="rounded overflow-hidden mb-2 border" style="background:#f8f9fa;">
                <?php
                    $images = $betail->images;
                    $video  = $betail->video_media;
                ?>

                <?php if($images->isNotEmpty()): ?>
                    <img id="main-photo"
                         src="<?php echo e(asset('storage/' . $images->first()->chemin)); ?>"
                         alt="<?php echo e($betail->race); ?>"
                         class="w-100"
                         style="height:380px;object-fit:contain;">
                <?php elseif($betail->photo): ?>
                    <img src="<?php echo e(asset('storage/' . $betail->photo)); ?>"
                         alt="<?php echo e($betail->race); ?>"
                         class="w-100"
                         style="height:380px;object-fit:contain;">
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center bg-light"
                         style="height:380px;">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                <?php endif; ?>
            </div>

            
            <?php if($images->count() > 1): ?>
                <div class="d-flex gap-2 flex-wrap mb-2">
                    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/' . $img->chemin)); ?>"
                             alt="Photo <?php echo e($loop->iteration); ?>"
                             onclick="document.getElementById('main-photo').src = this.src; this.closest('.d-flex').querySelectorAll('img').forEach(i=>i.style.border='2px solid #dee2e6'); this.style.border='2px solid #198754';"
                             class="rounded border"
                             style="width:72px;height:72px;object-fit:contain;cursor:pointer;transition:opacity .2s;<?php echo e($loop->first ? 'border:2px solid #198754!important;' : ''); ?>"
                             onmouseover="this.style.opacity='0.7'"
                             onmouseout="this.style.opacity='1'">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            
            <?php if($video): ?>
                <div class="mt-3">
                    <p class="fw-semibold mb-2">
                        <i class="fas fa-video me-2 text-success"></i>Vidéo de présentation
                    </p>
                    <video controls class="w-100 rounded border" style="max-height:280px;background:#000;" preload="metadata">
                        <source src="<?php echo e(asset('storage/' . $video->chemin)); ?>" type="video/mp4">
                        <source src="<?php echo e(asset('storage/' . $video->chemin)); ?>" type="video/webm">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                </div>
            <?php elseif($betail->video): ?>
                <div class="mt-3">
                    <p class="fw-semibold mb-2">
                        <i class="fas fa-video me-2 text-success"></i>Vidéo de présentation
                    </p>
                    <video controls class="w-100 rounded border" style="max-height:280px;background:#000;" preload="metadata">
                        <source src="<?php echo e(asset('storage/' . $betail->video)); ?>" type="video/mp4">
                        <source src="<?php echo e(asset('storage/' . $betail->video)); ?>" type="video/webm">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                </div>
            <?php endif; ?>

        </div>

        
        <div class="col-lg-6">
            <div class="d-flex align-items-center gap-2 mb-2">
                <?php if($betail->categorie): ?>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        <?php echo e($betail->categorie->nom_categorie); ?>

                    </span>
                <?php endif; ?>
                <span class="badge <?php echo e($betail->disponibilite ? 'bg-success' : 'bg-danger'); ?>">
                    <?php echo e($betail->disponibilite ? 'Disponible' : 'Indisponible'); ?>

                </span>
            </div>

            <h1 class="fw-bold mb-1"><?php echo e($betail->race); ?></h1>
            <p class="text-muted mb-3">
                <i class="fas fa-map-marker-alt me-1"></i><?php echo e($betail->origine); ?>

            </p>

            <div class="bg-success-subtle rounded p-3 mb-4">
                <span class="fs-2 fw-bold text-success">
                    <?php echo e(number_format($betail->prix, 0, ',', ' ')); ?> FCFA
                </span>
            </div>

            
            <div class="row g-2 mb-4">
                <div class="col-6">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-birthday-cake text-success d-block mb-1"></i>
                        <small class="text-muted d-block">Âge</small>
                        <strong><?php echo e($betail->age); ?> an<?php echo e($betail->age > 1 ? 's' : ''); ?></strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-weight text-success d-block mb-1"></i>
                        <small class="text-muted d-block">Poids</small>
                        <strong><?php echo e($betail->poids); ?> kg</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-map-marker-alt text-success d-block mb-1"></i>
                        <small class="text-muted d-block">Origine</small>
                        <strong><?php echo e($betail->origine); ?></strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-boxes text-success d-block mb-1"></i>
                        <small class="text-muted d-block">Stock</small>
                        <strong><?php echo e($betail->quantite); ?> disponible(s)</strong>
                    </div>
                </div>
            </div>

            
            <?php if($betail->disponibilite && $betail->quantite > 0): ?>
                <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="betail_id" value="<?php echo e($betail->id_betail); ?>">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <label class="fw-semibold mb-0">Quantité :</label>
                        <input type="number" name="quantite"
                               value="1" min="1" max="<?php echo e($betail->quantite); ?>"
                               class="form-control"
                               style="width:90px;">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-lg flex-fill">
                            <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
                        </button>
                        <a href="<?php echo e(route('cart.checkout')); ?>" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-bolt me-1"></i>Commander
                        </a>
                    </div>
                </form>
            <?php else: ?>
                <button class="btn btn-secondary btn-lg w-100" disabled>
                    <i class="fas fa-times-circle me-2"></i>Indisponible
                </button>
            <?php endif; ?>

            
            <div class="mt-4 p-3 bg-light rounded">
                <small class="text-muted">
                    <i class="fas fa-truck text-success me-2"></i>Livraison à domicile disponible<br>
                    <i class="fas fa-hand-holding-usd text-success me-2"></i>Paiement à la livraison<br>
                    <i class="fas fa-phone text-success me-2"></i>Confirmation par appel
                </small>
            </div>
        </div>
    </div>

    
    <div class="mt-5">
        <h4 class="fw-bold mb-3">
            <i class="fas fa-map-marker-alt me-2 text-success"></i>Localisation de la bête en direct
        </h4>

        <?php if($betail->localisation_lat && $betail->localisation_lng): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white d-flex align-items-center gap-2">
                    <span class="badge bg-light text-success">
                        <i class="fas fa-circle me-1" style="font-size:8px;color:#28a745;animation:pulse 1.5s infinite;"></i>
                        En direct
                    </span>
                    <span>Position actuelle — Mise à jour automatique</span>
                </div>
                <div class="card-body p-0" style="height:350px;position:relative;">
                    <div id="map-betail" style="height:100%;width:100%;border-radius:0 0 8px 8px;"></div>
                </div>
                <div class="card-footer small text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Dernière position enregistrée :
                    <?php if($betail->localisation_updated_at): ?>
                        <?php echo e(\Carbon\Carbon::parse($betail->localisation_updated_at)->diffForHumans()); ?>

                    <?php else: ?>
                        Disponible
                    <?php endif; ?>
                    — Coordonnées : <?php echo e($betail->localisation_lat); ?>, <?php echo e($betail->localisation_lng); ?>

                </div>
            </div>

            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const lat = <?php echo e($betail->localisation_lat); ?>;
                    const lng = <?php echo e($betail->localisation_lng); ?>;

                    const map = L.map('map-betail').setView([lat, lng], 14);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    const icon = L.divIcon({
                        html: '<div style="background:#198754;color:white;border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 2px 8px rgba(0,0,0,0.3);border:2px solid white;">🐄</div>',
                        iconSize: [40, 40],
                        iconAnchor: [20, 20],
                        className: ''
                    });

                    const marker = L.marker([lat, lng], { icon })
                        .addTo(map)
                        .bindPopup(`
                            <strong><?php echo e($betail->race); ?></strong><br>
                            <?php echo e($betail->origine); ?><br>
                            <span class="text-muted"><?php echo e(number_format($betail->prix, 0, ',', ' ')); ?> FCFA</span>
                        `)
                        .openPopup();

                    // Cercle de zone approximative
                    L.circle([lat, lng], { radius: 500, color: '#198754', fillOpacity: 0.08, weight: 1 }).addTo(map);

                    // Auto-refresh toutes les 30s
                    setInterval(function () {
                        fetch('/api/betails/<?php echo e($betail->id_betail); ?>/location')
                            .then(r => r.json())
                            .then(data => {
                                if (data.lat && data.lng) {
                                    marker.setLatLng([data.lat, data.lng]);
                                    map.panTo([data.lat, data.lng]);
                                }
                            })
                            .catch(() => {});
                    }, 30000);
                });
            </script>
            <style>
                @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
            </style>
        <?php else: ?>
            <div class="card border-0 bg-light">
                <div class="card-body text-center py-4">
                    <i class="fas fa-map-marked-alt fa-3x text-muted mb-3 d-block"></i>
                    <p class="text-muted mb-0">La localisation en direct n'est pas encore disponible pour ce bétail.</p>
                    <small class="text-muted">Contactez-nous pour connaître l'emplacement exact.</small>
                </div>
            </div>
        <?php endif; ?>
    </div>

    
    <?php if($suggestions->isNotEmpty()): ?>
        <hr class="my-5">
        <h4 class="fw-bold mb-4">
            <i class="fas fa-th-large me-2 text-success"></i>Vous aimerez aussi
        </h4>
        <div class="row g-3">
            <?php $__currentLoopData = $suggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <?php
                            $img = $s->images()->first();
                        ?>
                        <?php if($img): ?>
                            <img src="<?php echo e(asset('storage/' . $img->chemin)); ?>"
                                 class="card-img-top"
                                 style="height:140px;object-fit:contain;"
                                 alt="<?php echo e($s->race); ?>">
                        <?php elseif($s->photo): ?>
                            <img src="<?php echo e(asset('storage/' . $s->photo)); ?>"
                                 class="card-img-top"
                                 style="height:140px;object-fit:contain;"
                                 alt="<?php echo e($s->race); ?>">
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                 style="height:140px;">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body p-2">
                            <p class="fw-semibold mb-0 small"><?php echo e($s->race); ?></p>
                            <p class="text-success fw-bold small mb-1">
                                <?php echo e(number_format($s->prix, 0, ',', ' ')); ?> FCFA
                            </p>
                            <a href="<?php echo e(route('betails.show', $s->id_betail)); ?>"
                               class="btn btn-outline-success btn-sm w-100">Voir</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Own project\saga_chap\resources\views/client/betail/show.blade.php ENDPATH**/ ?>