<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsHeroSectionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsHeroSectionResource;

class ListCmsHeroSections extends ListRecords
{
    protected static string $resource = CmsHeroSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}