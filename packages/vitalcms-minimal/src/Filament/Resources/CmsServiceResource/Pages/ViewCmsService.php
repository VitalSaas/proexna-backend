<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsServiceResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsServiceResource;

class ViewCmsService extends ViewRecord
{
    protected static string $resource = CmsServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}