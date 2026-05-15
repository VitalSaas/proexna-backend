<?php

namespace App\Filament\Resources\JobApplications\Tables;

use App\Models\JobApplication;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Postulante')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('vacancy.title')
                    ->label('Vacante')
                    ->placeholder('Postulación Abierta')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('position_interest')
                    ->label('Interés')
                    ->toggleable(),

                TextColumn::make('city')
                    ->label('Ciudad')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => JobApplication::getStatuses()[$state] ?? $state)
                    ->color(fn (string $state) => match ($state) {
                        'nuevo' => 'warning',
                        'contactado' => 'info',
                        'entrevista' => 'primary',
                        'contratado' => 'success',
                        'descartado' => 'danger',
                        'archivado' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Recibida')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('contacted_at')
                    ->label('Contactado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(JobApplication::getStatuses()),

                SelectFilter::make('job_vacancy_id')
                    ->label('Vacante')
                    ->relationship('vacancy', 'title'),
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
            ->defaultSort('created_at', 'desc');
    }
}
