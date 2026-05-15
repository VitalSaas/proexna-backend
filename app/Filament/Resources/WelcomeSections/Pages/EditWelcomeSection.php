<?php

namespace App\Filament\Resources\WelcomeSections\Pages;

use App\Filament\Resources\WelcomeSections\WelcomeSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWelcomeSection extends EditRecord
{
    protected static string $resource = WelcomeSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
