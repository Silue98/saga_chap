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
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data            = $this->form->getRawState();
        $betailId        = $this->record->id_betail;
        $imagePrincipale = $data['image_principale'] ?? null;

        // Filtrer les fichiers temporaires
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

        // S'il y a de nouvelles images définitives → remplacer les anciennes
        if (!empty($nouvellesImages)) {
            foreach ($this->record->images as $media) {
                Storage::disk('public')->delete($media->chemin);
                $media->delete();
            }

            $ordre = 0;
            foreach ($nouvellesImages as $chemin) {
                $estPrincipale = $imagePrincipale
                    ? ($chemin === $imagePrincipale)
                    : ($ordre === 0);

                BetailMedia::create([
                    'id_betail'  => $betailId,
                    'type'       => 'image',
                    'chemin'     => $chemin,
                    'principale' => $estPrincipale,
                    'ordre'      => $ordre,
                ]);
                $ordre++;
            }
        } elseif ($imagePrincipale) {
            // Pas de nouvel upload — juste changer l'image principale
            BetailMedia::where('id_betail', $betailId)
                ->where('type', 'image')
                ->update(['principale' => false]);
            BetailMedia::where('id_betail', $betailId)
                ->where('chemin', $imagePrincipale)
                ->update(['principale' => true]);
        }

        // Vidéo
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
