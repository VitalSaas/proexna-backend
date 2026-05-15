<?php

namespace App\Filament\Resources\WelcomeSections\Pages;

use App\Filament\Resources\WelcomeSections\WelcomeSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWelcomeSection extends ViewRecord
{
    protected static string $resource = WelcomeSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
