<?php

namespace App\Filament\Resources\BetailResource\Pages;

use App\Filament\Resources\BetailResource;
use App\Models\BetailMedia;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditBetail extends EditRecord
{
    protected static string $resource = BetailResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function afterSave(): void
    {
        $data     = $this->form->getRawState();
        $betailId = $this->record->id_betail;

        // ── Nouvelles images uploadées ──
        $nouvellesImages = [];
        if (!empty($data['images_upload'])) {
            $images = is_array($data['images_upload'])
                ? array_values($data['images_upload'])
                : [$data['images_upload']];

            foreach ($images as $chemin) {
                if (!str_contains($chemin, 'livewire-tmp') && !str_contains($chemin, 'tmp/')) {
                    $nouvellesImages[] = $chemin;
                }
            }
        }

        if (!empty($nouvellesImages)) {
            // Si toggle "remplacer toutes" est activé → supprimer les anciennes
            if (!empty($data['supprimer_toutes_images'])) {
                foreach ($this->record->images as $media) {
                    Storage::disk('public')->delete($media->chemin);
                    $media->delete();
                }
                // Ajouter les nouvelles, première = principale
                $ordre = 0;
                foreach ($nouvellesImages as $chemin) {
                    BetailMedia::create([
                        'id_betail'  => $betailId,
                        'type'       => 'image',
                        'chemin'     => $chemin,
                        'principale' => $ordre === 0,
                        'ordre'      => $ordre,
                    ]);
                    $ordre++;
                }
            } else {
                // Ajouter les nouvelles images sans supprimer les anciennes
                $maxOrdre = BetailMedia::where('id_betail', $betailId)
                    ->where('type', 'image')
                    ->max('ordre') ?? -1;

                $dejaUnePrincipale = BetailMedia::where('id_betail', $betailId)
                    ->where('type', 'image')
                    ->where('principale', true)
                    ->exists();

                $ordre = $maxOrdre + 1;
                foreach ($nouvellesImages as $chemin) {
                    BetailMedia::create([
                        'id_betail'  => $betailId,
                        'type'       => 'image',
                        'chemin'     => $chemin,
                        'principale' => !$dejaUnePrincipale && $ordre === ($maxOrdre + 1),
                        'ordre'      => $ordre,
                    ]);
                    $dejaUnePrincipale = true;
                    $ordre++;
                }
            }
        }

        // ── Changer l'image principale parmi les existantes ──
        if (!empty($data['image_principale_chemin'])) {
            $nouvellePrincipale = $data['image_principale_chemin'];
            // Vérifier que ce chemin appartient bien à ce bétail
            $exists = BetailMedia::where('id_betail', $betailId)
                ->where('type', 'image')
                ->where('chemin', $nouvellePrincipale)
                ->exists();

            if ($exists) {
                BetailMedia::where('id_betail', $betailId)
                    ->where('type', 'image')
                    ->update(['principale' => false]);

                BetailMedia::where('id_betail', $betailId)
                    ->where('chemin', $nouvellePrincipale)
                    ->update(['principale' => true]);
            }
        }

        // ── Vidéo ──
        if (!empty($data['video_upload'])) {
            $chemins = is_array($data['video_upload'])
                ? array_values($data['video_upload'])
                : [$data['video_upload']];

            foreach ($chemins as $chemin) {
                if (str_contains($chemin, 'livewire-tmp') || str_contains($chemin, 'tmp/')) {
                    continue;
                }
                $oldVideo = $this->record->video_media;
                if ($oldVideo) {
                    Storage::disk('public')->delete($oldVideo->chemin);
                    $oldVideo->delete();
                }
                BetailMedia::create([
                    'id_betail'  => $betailId,
                    'type'       => 'video',
                    'chemin'     => $chemin,
                    'principale' => false,
                    'ordre'      => 0,
                ]);
                break;
            }
        }
    }
}
