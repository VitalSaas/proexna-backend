<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsServiceResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsServiceResource;

class EditCmsService extends EditRecord
{
    protected static string $resource = CmsServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}