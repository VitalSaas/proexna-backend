<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsHeroSectionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsHeroSectionResource;

class EditCmsHeroSection extends EditRecord
{
    protected static string $resource = CmsHeroSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}