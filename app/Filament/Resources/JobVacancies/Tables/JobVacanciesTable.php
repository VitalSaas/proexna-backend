<?php

namespace App\Filament\Resources\JobVacancies\Tables;

use App\Models\JobVacancy;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class JobVacanciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Puesto')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('department')
                    ->label('Área')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('location')
                    ->label('Ubicación')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('employment_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => $state ? (JobVacancy::getEmploymentTypes()[$state] ?? $state) : null)
                    ->sortable(),

                TextColumn::make('applications_count')
                    ->label('Postulaciones')
                    ->counts('applications')
                    ->badge()
                    ->color('success'),

                TextColumn::make('posted_at')
                    ->label('Publicada')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('closes_at')
                    ->label('Cierra')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Activa')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Orden')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('employment_type')
                    ->label('Tipo de Contratación')
                    ->options(JobVacancy::getEmploymentTypes()),

                TernaryFilter::make('is_active')
                    ->label('Activa'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
    }
}
