<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Betail;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categorie::orderBy('nom_categorie')->get();

        $query = Betail::with(['categorie', 'medias'])->where('disponibilite', true);

        if ($request->filled('categorie')) {
            $query->where('id_categorie_betail', $request->categorie);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('race', 'like', "%{$search}%")
                  ->orWhere('origine', 'like', "%{$search}%");
            });
        }

        // Tri : d'abord ceux avec photo, ensuite par id desc
        $betails = $query->orderByDesc('id_betail')->get();

        return view('welcome', compact('categories', 'betails'));
    }

    public function show(string $id)
    {
        $betail    = Betail::with(['categorie', 'medias'])->findOrFail($id);
        $categorie = $betail->categorie;

        // Suggestions : autres bétails de la même catégorie
        $suggestions = Betail::with('medias')
            ->where('id_categorie_betail', $betail->id_categorie_betail)
            ->where('id_betail', '!=', $betail->id_betail)
            ->where('disponibilite', true)
            ->take(4)
            ->get();

        return view('client.betail.show', compact('betail', 'categorie', 'suggestions'));
    }
}
