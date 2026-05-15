<?php

namespace App\Filament\Resources\WhyChooseUsItems\Pages;

use App\Filament\Resources\WhyChooseUsItems\WhyChooseUsItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhyChooseUsItem extends EditRecord
{
    protected static string $resource = WhyChooseUsItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
