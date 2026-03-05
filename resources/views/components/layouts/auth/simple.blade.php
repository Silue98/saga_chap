<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }} — SagaChap</title>
    @include('partials.head')
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; }
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
        }
        /* Panneau gauche vert */
        .auth-left {
            background: linear-gradient(160deg, #16a34a 0%, #14532d 100%);
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: white;
        }
        .auth-left .brand-logo {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 12px;
        }
        .auth-left .brand-tagline {
            font-size: 1.05rem;
            opacity: 0.85;
            text-align: center;
            max-width: 320px;
            line-height: 1.6;
        }
        .auth-left .feature-list {
            margin-top: 40px;
            list-style: none;
            padding: 0;
            width: 100%;
            max-width: 320px;
        }
        .auth-left .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .auth-left .feature-list li:last-child { border-bottom: none; }
        .auth-left .feature-list li span.icon {
            font-size: 1.2rem;
            width: 28px;
            text-align: center;
        }
        /* Panneau droit formulaire */
        .auth-right {
            width: 480px;
            min-width: 320px;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
        }
        .auth-right .back-link {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 0.85rem;
            color: #6b7280;
            text-decoration: none;
        }
        .auth-right .back-link:hover { color: #16a34a; }
        /* Responsive */
        @media (max-width: 768px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; padding: 32px 24px; }
        }
    </style>
</head>
<body>
<div class="auth-wrapper" style="position:relative;">

    {{-- Panneau gauche : branding --}}
    <div class="auth-left">
        <div class="brand-logo">🐄 SagaChap</div>
        <p class="brand-tagline">
            La plateforme de référence pour acheter et vendre du bétail en ligne en toute confiance.
        </p>
        <ul class="feature-list">
            <li>
                <span class="icon">🐑</span>
                <span>Moutons, Bœufs, Cabris et plus</span>
            </li>
            <li>
                <span class="icon">📸</span>
                <span>Photos et vidéos de chaque animal</span>
            </li>
            <li>
                <span class="icon">🛒</span>
                <span>Commande en ligne rapide et sécurisée</span>
            </li>
            <li>
                <span class="icon">🚚</span>
                <span>Livraison partout en Côte d'Ivoire</span>
            </li>
            <li>
                <span class="icon">📦</span>
                <span>Suivi de commande en temps réel</span>
            </li>
        </ul>
    </div>

    {{-- Panneau droit : formulaire --}}
    <div class="auth-right" style="position:relative;">
        <a href="{{ route('home') }}" class="back-link">
            ← Retour à la boutique
        </a>

        {{-- Logo mobile (visible seulement sur petit écran) --}}
        <div class="d-md-none text-center mb-4">
            <span style="font-size:1.8rem;font-weight:800;color:#16a34a;">🐄 SagaChap</span>
        </div>

        <div style="width:100%;max-width:380px;">
            {{ $slot }}
        </div>

        <p class="mt-4 text-center" style="font-size:0.75rem;color:#9ca3af;">
            Développé par <strong>SS — Silué Samuel</strong><br>
            <a href="tel:+2250788718510" style="color:#16a34a;text-decoration:none;">+225 07 88 71 85 10</a>
        </p>
    </div>

</div>
@fluxScripts
</body>
</html>
