<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsContactSubmissionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsContactSubmissionResource;

class ListCmsContactSubmissions extends ListRecords
{
    protected static string $resource = CmsContactSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action - submissions are created via API
        ];
    }
}