<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsServiceResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsServiceResource;

class ListCmsServices extends ListRecords
{
    protected static string $resource = CmsServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}