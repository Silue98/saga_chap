<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\Cart;

class MergeCartOnLogin
{
    /**
     * Après connexion, fusionner le panier de session dans le compte utilisateur.
     * Si un article existe déjà dans le panier du compte, on additionne les quantités.
     */
    public function handle(Login $event): void
    {
        $sessionId = session()->getId();
        $userId    = $event->user->id;

        $sessionItems = Cart::where('session_id', $sessionId)
                            ->whereNull('user_id')
                            ->get();

        foreach ($sessionItems as $sessionItem) {
            $existing = Cart::where('user_id', $userId)
                            ->where('id_betail', $sessionItem->id_betail)
                            ->first();

            if ($existing) {
                // Additionner les quantités
                $existing->increment('quantite', $sessionItem->quantite);
                $sessionItem->delete();
            } else {
                // Rattacher l'article au compte
                $sessionItem->update([
                    'user_id'    => $userId,
                    'session_id' => $sessionId,
                ]);
            }
        }
    }
}
