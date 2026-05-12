<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsHeroSectionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsHeroSectionResource;

class ViewCmsHeroSection extends ViewRecord
{
    protected static string $resource = CmsHeroSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}