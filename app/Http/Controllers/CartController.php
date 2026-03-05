<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use App\Models\Cart;
use App\Models\Betail;
use App\Models\Commande;
use App\Models\CommandeItem;
use App\Models\User;
use App\Mail\CommandeConfirmation;

class CartController extends Controller
{
    private function cartQuery()
    {
        $sessionId = session()->getId();
        $userId    = Auth::check() ? Auth::id() : null;

        return Cart::with('betail')->where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId)->orWhere('session_id', $sessionId);
            } else {
                $q->where('session_id', $sessionId);
            }
        });
    }

    // Afficher le panier
    public function index()
    {
        $cartItems = $this->cartQuery()->get();
        $total     = $cartItems->sum(fn ($item) => $item->betail ? $item->betail->prix * $item->quantite : 0);

        return view('client.cart.index', compact('cartItems', 'total'));
    }

    // Ajouter au panier (via formulaire classique)
    public function add(Request $request)
    {
        $request->validate([
            'betail_id' => 'required|integer|exists:betail,id_betail',
            'quantite'  => 'integer|min:1',
        ]);

        $betailId  = $request->input('betail_id');
        $quantity  = $request->input('quantite', 1);
        $sessionId = session()->getId();
        $userId    = Auth::check() ? Auth::id() : null;

        $betail = Betail::findOrFail($betailId);
        if (!$betail->disponibilite) {
            return back()->with('error', 'Ce bétail n\'est plus disponible.');
        }

        $query = Cart::where('id_betail', $betailId);
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }
        $cartItem = $query->first();

        if ($cartItem) {
            $cartItem->increment('quantite', $quantity);
        } else {
            Cart::create([
                'user_id'    => $userId,
                'session_id' => $sessionId,
                'id_betail'  => $betailId,
                'quantite'   => $quantity,
            ]);
        }

        return back()->with('cart_success', 'Bétail ajouté au panier !');
    }

    // Modifier la quantité
    public function update(Request $request, $id)
    {
        $request->validate(['quantite' => 'required|integer|min:1']);

        $cartItem = Cart::findOrFail($id);
        $this->authorizeCartItem($cartItem);

        $cartItem->update(['quantite' => $request->quantite]);

        return back()->with('cart_success', 'Panier mis à jour.');
    }

    // Supprimer un article du panier
    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $this->authorizeCartItem($cartItem);
        $cartItem->delete();

        return back()->with('cart_success', 'Article supprimé du panier.');
    }

    // Vider le panier
    public function clear()
    {
        $this->cartQuery()->delete();
        return back()->with('cart_success', 'Panier vidé.');
    }

    // Afficher le formulaire de checkout
    public function checkout()
    {
        $cartItems = $this->cartQuery()->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }
        $total = $cartItems->sum(fn ($item) => $item->betail ? $item->betail->prix * $item->quantite : 0);

        return view('client.betail.checkout', compact('cartItems', 'total'));
    }

    // Valider la commande
    public function placeOrder(Request $request)
    {
        $request->validate([
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'telephone' => 'required|string|max:20',
            'adresse'   => 'required|string|max:255',
            'ville'     => 'required|string|max:100',
        ]);

        $cartItems = $this->cartQuery()->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $total = $cartItems->sum(fn ($item) => $item->betail ? $item->betail->prix * $item->quantite : 0);

        // Créer la commande
        $commande = Commande::create([
            'user_id'       => Auth::check() ? Auth::id() : null,
            'session_id'    => session()->getId(),
            'nom'           => $request->nom,
            'prenom'        => $request->prenom,
            'telephone'     => $request->telephone,
            'adresse'       => $request->adresse,
            'ville'         => $request->ville,
            'montant_total' => $total,
            'statut'        => 'en_attente',
        ]);

        // Créer les lignes de commande
        foreach ($cartItems as $item) {
            if (!$item->betail) continue;
            CommandeItem::create([
                'commande_id'   => $commande->id,
                'id_betail'     => $item->id_betail,
                'quantite'      => $item->quantite,
                'prix_unitaire' => $item->betail->prix,
            ]);
        }

        // Vider le panier
        $this->cartQuery()->delete();

        // Envoyer l'email de confirmation si une adresse email est disponible
        $email = Auth::check()
            ? Auth::user()->email
            : $request->input('email');

        if ($email) {
            try {
                Mail::to($email)->send(new CommandeConfirmation($commande->load('items.betail')));
            } catch (\Exception $e) {
                // Ne pas bloquer la commande si l'email échoue
                \Log::warning('Email confirmation non envoyé : ' . $e->getMessage());
            }
        }

        // Notifier tous les admins via Filament
        $admins = User::where('is_admin', true)->get();
        Notification::make()
            ->title('🛒 Nouvelle commande #' . $commande->id)
            ->body($commande->prenom . ' ' . $commande->nom . ' — ' . number_format($commande->montant_total, 0, ',', ' ') . ' FCFA')
            ->warning()
            ->actions([
                Action::make('voir')
                    ->label('Traiter la commande')
                    ->url(route('filament.admin.resources.commandes.edit', $commande->id))
                    ->markAsRead(),
            ])
            ->sendToDatabase($admins);

        return redirect()->route('order.confirmation', $commande->id)
                         ->with('order_success', 'Commande passée avec succès !');
    }

    // Page de confirmation — accessible uniquement au propriétaire
    public function confirmation($id)
    {
        $commande = Commande::with('items.betail')->findOrFail($id);

        $sessionId = session()->getId();
        $userId    = Auth::check() ? Auth::id() : null;

        $isOwner = ($commande->session_id === $sessionId) ||
                   ($userId && $commande->user_id == $userId);

        if (!$isOwner) {
            abort(403, 'Accès non autorisé à cette commande.');
        }

        return view('client.cart.confirmation', compact('commande'));
    }

    // Sécurité : vérifier que l'item appartient à la session/user
    private function authorizeCartItem(Cart $item)
    {
        $sessionId = session()->getId();
        $userId    = Auth::check() ? Auth::id() : null;

        $owned = ($item->session_id === $sessionId) ||
                 ($userId && $item->user_id == $userId);

        if (!$owned) {
            abort(403);
        }
    }
}
