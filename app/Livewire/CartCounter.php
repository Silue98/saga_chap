<?php

namespace App\Livewire;

use Livewire\Component;

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartCounter extends Component
{
    public $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    public function addToCart($articleId, $quantity = 1)
    {
        if (!is_numeric($articleId) || $quantity < 1) {
            return;
        }

        $sessionId = session()->getId();
        $userId = Auth::check() ? Auth::id() : null;

        // Vérifier si l'article existe déjà dans le panier
        $cartItem = Cart::where('article_id', $articleId)
            ->where(function ($query) use ($userId, $sessionId) {
                $query->where('session_id', $sessionId);
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->first();

        if ($cartItem) {
            // Incrémenter la quantité
            $cartItem->increment('quantite', $quantity);
        } else {
            // Ajouter un nouvel article
            Cart::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'article_id' => $articleId,
                'quantite' => $quantity,
            ]);
        }

        // Mettre à jour le compteur
        $this->updateCartCount();

        // Émettre une notification
        session()->flash('cart_updated', 'Article ajouté au panier !');
    }

    public function updateCartCount()
    {
        $this->cartCount = Cart::where('session_id', session()->getId())
            ->when(Auth::check(), function ($query) {
                return $query->orWhere('user_id', Auth::id());
            })
            ->sum('quantite') ?? 0;
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}