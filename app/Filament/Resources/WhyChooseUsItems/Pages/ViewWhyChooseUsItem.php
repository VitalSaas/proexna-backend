<?php

namespace App\Filament\Resources\WhyChooseUsItems\Pages;

use App\Filament\Resources\WhyChooseUsItems\WhyChooseUsItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWhyChooseUsItem extends ViewRecord
{
    protected static string $resource = WhyChooseUsItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
