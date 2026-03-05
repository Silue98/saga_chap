<x-filament-widgets::widget>
    @if($nbEnAttente > 0)
        <div class="flex items-center gap-4 rounded-xl border border-warning-300 bg-warning-50 px-6 py-4 dark:border-warning-700 dark:bg-warning-950">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-warning-100 dark:bg-warning-900">
                <x-heroicon-o-bell-alert class="h-6 w-6 text-warning-600 dark:text-warning-400"/>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-warning-800 dark:text-warning-200">
                    {{ $nbEnAttente }} commande{{ $nbEnAttente > 1 ? 's' : '' }} en attente de traitement
                </p>
                <p class="text-xs text-warning-600 dark:text-warning-400">
                    Cliquez sur "Commandes" pour les traiter
                </p>
            </div>
            <a href="{{ route('filament.admin.resources.commandes.index') }}"
               class="rounded-lg bg-warning-500 px-4 py-2 text-sm font-medium text-white hover:bg-warning-600 transition">
                Voir les commandes →
            </a>
        </div>
    @else
        <div class="flex items-center gap-3 rounded-xl border border-success-200 bg-success-50 px-6 py-3 dark:border-success-800 dark:bg-success-950">
            <x-heroicon-o-check-circle class="h-5 w-5 text-success-500"/>
            <p class="text-sm text-success-700 dark:text-success-300">
                Toutes les commandes sont traitées — Aucune en attente ✓
            </p>
        </div>
    @endif
</x-filament-widgets::widget>
