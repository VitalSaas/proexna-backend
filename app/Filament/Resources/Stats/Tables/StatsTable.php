<?php

namespace App\Filament\Resources\Stats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class StatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('icon')->label('Icono'),
                TextColumn::make('value')->label('Valor')->sortable(),
                TextColumn::make('label')->label('Etiqueta')->searchable()->sortable(),
                IconColumn::make('is_active')->label('Activo')->boolean()->sortable(),
                TextColumn::make('sort_order')->label('Orden')->numeric()->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Activo'),
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
