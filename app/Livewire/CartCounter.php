<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Betail;

class CartCounter extends Component
{
    public int $cartCount = 0;
    public ?string $flashSuccess = null;
    public ?string $flashError   = null;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount(): void
    {
        $this->updateCartCount();
    }

    public function addToCart(int $betailId, int $quantity = 1): void
    {
        $betail = Betail::find($betailId);

        if (!$betail || !$betail->disponibilite) {
            $this->flashError = 'Ce bétail n\'est plus disponible.';
            return;
        }

        $sessionId = session()->getId();
        $userId    = Auth::check() ? Auth::id() : null;

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

        $this->flashSuccess = $betail->race . ' ajouté au panier !';
        $this->updateCartCount();
    }

    public function updateCartCount(): void
    {
        $sessionId = session()->getId();
        $userId    = Auth::check() ? Auth::id() : null;

        $query = Cart::query();
        if ($userId) {
            $query->where(function ($q) use ($userId, $sessionId) {
                $q->where('user_id', $userId)
                  ->orWhere('session_id', $sessionId);
            });
        } else {
            $query->where('session_id', $sessionId);
        }

        $this->cartCount = (int) ($query->sum('quantite') ?? 0);
        $this->dispatch('cartCountUpdated', count: $this->cartCount);
    }

    public function clearFlash(): void
    {
        $this->flashSuccess = null;
        $this->flashError   = null;
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
