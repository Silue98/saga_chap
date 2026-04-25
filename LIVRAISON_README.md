# 🐄 SÂGACHAP — Guide de déploiement

## Slogans ajoutés
- **"Le bétail de qualité, à portée de clic"**
- **"Même ce que tu penses pas trouver, nous on te livre ça."**

---

## ✅ Commandes à exécuter après mise à jour

```bash
# 1. Installer les dépendances
composer install --no-dev
npm install && npm run build

# 2. Configurer le .env
cp .env.example .env
php artisan key:generate

# 3. Lancer les migrations (IMPORTANT : nouvelle migration GPS)
php artisan migrate

# 4. Lier le stockage public
php artisan storage:link

# 5. Vider les caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🆕 Nouvelles fonctionnalités livrées

### 1. Slogans (navbar + footer + hero + page confirmation)
- "Le bétail de qualité, à portée de clic" — dans le titre du navigateur, navbar, footer et hero
- "Même ce que tu penses pas trouver, nous on te livre ça." — hero + page de confirmation

### 2. Commande sans inscription ✅
- Déjà fonctionnel — le checkout accepte les invités
- Badge "Sans inscription requise" ajouté sur la page checkout
- Email optionnel pour les invités

### 3. Localisation GPS de la bête en temps réel 📍
- Nouvelle migration : `localisation_lat`, `localisation_lng`, `localisation_adresse`
- Carte Leaflet (OpenStreetMap) sur la fiche de chaque bétail
- Auto-refresh toutes les 30 secondes
- Interface admin : champs GPS dans Filament (section "Localisation GPS")
- Badge "En direct" sur les cartes de la liste si GPS activé

**Pour activer la localisation d'un bétail :**
1. Aller dans `/admin` > Bétails > Modifier
2. Remplir Latitude et Longitude dans la section "Localisation GPS"
3. Exemple Abidjan : Lat `5.3484`, Lng `-4.0167`

### 4. Vidéos courtes ✅ (fonctionnel)
- Upload MP4/WebM/MOV jusqu'à 50MB depuis l'admin
- Lecteur vidéo sur la fiche du bétail
- Badge "Vidéo" sur les cartes de la liste si une vidéo existe

### 5. Corrections de bugs
- Validation email ajoutée dans `placeOrder`
- Décrémentation du stock à la commande
- Mise à `disponibilite=false` si stock = 0 après commande
- Vérification de stock avant validation de commande
- Eager loading des médias pour de meilleures performances
- Images Filament depuis `betail_medias` plutôt que `photo` seul

---

## 📂 Fichiers modifiés

| Fichier | Modification |
|---------|-------------|
| `resources/views/welcome.blade.php` | Hero + slogans + badges vidéo/GPS |
| `resources/views/client/betail/show.blade.php` | Section carte GPS Leaflet |
| `resources/views/client/betail/checkout.blade.php` | Badge "sans inscription" |
| `resources/views/client/cart/confirmation.blade.php` | Slogan + images + lien compte |
| `resources/views/components/layouts/app.blade.php` | Slogans navbar + footer |
| `app/Http/Controllers/HomeController.php` | Eager loading médias |
| `app/Http/Controllers/CartController.php` | Fix validation, stock check |
| `app/Models/Betail.php` | Champs GPS + casts |
| `app/Filament/Resources/BetailResource.php` | Champs GPS + colonne GPS table |
| `routes/web.php` | Route API localisation |
| `database/migrations/2026_04_15_000001_add_localisation_to_betail_table.php` | **NOUVELLE** |

---

## 📞 Support
Développé par **SS — Silué Samuel**
- +225 07 88 71 85 10
- +225 05 86 67 11 13
