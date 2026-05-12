<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsContactSubmissionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsContactSubmissionResource;

class EditCmsContactSubmission extends EditRecord
{
    protected static string $resource = CmsContactSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}