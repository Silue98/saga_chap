<?php

namespace App\Filament\Resources\BetailResource\Pages;

use App\Filament\Resources\BetailResource;
use App\Models\BetailMedia;
use Filament\Resources\Pages\CreateRecord;

class CreateBetail extends CreateRecord
{
    protected static string $resource = BetailResource::class;

    protected function afterCreate(): void
    {
        $this->saveMedias($this->record->id_betail);
    }

    protected function saveMedias(int $betailId): void
    {
        $data = $this->form->getRawState();

        // ── Images ──
        if (!empty($data['images_upload'])) {
            $images = is_array($data['images_upload'])
                ? array_values($data['images_upload'])
                : [$data['images_upload']];

            $ordre = 0;
            foreach ($images as $chemin) {
                if (str_contains($chemin, 'livewire-tmp') || str_contains($chemin, 'tmp/')) {
                    continue;
                }
                BetailMedia::create([
                    'id_betail'  => $betailId,
                    'type'       => 'image',
                    'chemin'     => $chemin,
                    'principale' => $ordre === 0, // première image = principale par défaut
                    'ordre'      => $ordre,
                ]);
                $ordre++;
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
