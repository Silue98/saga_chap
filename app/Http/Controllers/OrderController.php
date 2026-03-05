<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;

class OrderController extends Controller
{
    // Historique des commandes du client connecté
    public function index()
    {
        $commandes = Commande::with('items.betail')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('client.orders.index', compact('commandes'));
    }

    // Détail d'une commande
    public function show($id)
    {
        $commande = Commande::with('items.betail')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('client.orders.show', compact('commande'));
    }
}
