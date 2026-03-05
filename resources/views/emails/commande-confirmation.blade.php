<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation commande #{{ $commande->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; color: #333; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #198754; color: white; padding: 30px 40px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 8px 0 0; opacity: 0.85; font-size: 14px; }
        .body { padding: 30px 40px; }
        .badge-success { display: inline-block; background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 999px; font-size: 13px; font-weight: bold; margin-bottom: 20px; }
        h2 { font-size: 16px; color: #198754; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px; margin-top: 24px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px 20px; margin-bottom: 20px; }
        .info-item label { font-size: 12px; color: #6b7280; display: block; }
        .info-item span { font-size: 14px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f9fafb; text-align: left; padding: 10px 12px; font-size: 13px; color: #6b7280; border-bottom: 1px solid #e5e7eb; }
        td { padding: 10px 12px; font-size: 14px; border-bottom: 1px solid #f3f4f6; }
        .total-row td { font-weight: bold; font-size: 15px; color: #198754; border-top: 2px solid #e5e7eb; border-bottom: none; }
        .alert { background: #fffbeb; border: 1px solid #fde68a; border-radius: 6px; padding: 14px 16px; font-size: 13px; color: #92400e; margin-top: 20px; }
        .footer { background: #f9fafb; text-align: center; padding: 20px 40px; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
        .footer a { color: #198754; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <h1>🐄 SagaChap</h1>
        <p>Vente de bétail en ligne</p>
    </div>

    {{-- Body --}}
    <div class="body">
        <div class="badge-success">✓ Commande confirmée</div>
        <p>Bonjour <strong>{{ $commande->prenom }} {{ $commande->nom }}</strong>,</p>
        <p>Votre commande <strong>#{{ $commande->id }}</strong> a bien été enregistrée. Notre équipe vous contactera au <strong>{{ $commande->telephone }}</strong> pour confirmer la livraison.</p>

        {{-- Infos livraison --}}
        <h2>📦 Informations de livraison</h2>
        <div class="info-grid">
            <div class="info-item">
                <label>Nom complet</label>
                <span>{{ $commande->prenom }} {{ $commande->nom }}</span>
            </div>
            <div class="info-item">
                <label>Téléphone</label>
                <span>{{ $commande->telephone }}</span>
            </div>
            <div class="info-item">
                <label>Ville</label>
                <span>{{ $commande->ville }}</span>
            </div>
            <div class="info-item">
                <label>Adresse</label>
                <span>{{ $commande->adresse }}</span>
            </div>
        </div>

        {{-- Articles --}}
        <h2>🛒 Détail de la commande</h2>
        <table>
            <thead>
                <tr>
                    <th>Bétail</th>
                    <th>Qté</th>
                    <th>Prix unit.</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->items as $item)
                    @if($item->betail)
                    <tr>
                        <td>{{ $item->betail->race }}</td>
                        <td>{{ $item->quantite }}</td>
                        <td>{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endif
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total à payer</td>
                    <td>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <div class="alert">
            💡 Le paiement s'effectue à la livraison. Notre équipe vous recontactera sous 24h pour confirmer la date et l'heure de livraison.
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Merci de votre confiance — <a href="{{ url('/') }}">SagaChap</a></p>
        <p>Cet email est envoyé automatiquement, merci de ne pas y répondre.</p>
    </div>

</div>
</body>
</html>
