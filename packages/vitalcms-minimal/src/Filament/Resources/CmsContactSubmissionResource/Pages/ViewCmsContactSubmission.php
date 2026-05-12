<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsContactSubmissionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsContactSubmissionResource;

class ViewCmsContactSubmission extends ViewRecord
{
    protected static string $resource = CmsContactSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        // Auto-mark as read when viewing
        if (!$this->record->isRead()) {
            $this->record->markAsRead();
        }
    }
}