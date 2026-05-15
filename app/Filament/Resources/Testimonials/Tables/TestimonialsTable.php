<?php

namespace App\Filament\Resources\Testimonials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->circular()
                    ->size(48),

                TextColumn::make('name')->label('Nombre')->searchable()->sortable(),
                TextColumn::make('role')->label('Cargo')->toggleable(),
                TextColumn::make('company')->label('Empresa')->toggleable(),

                TextColumn::make('rating')
                    ->label('Calificación')
                    ->formatStateUsing(fn (?int $state) => $state ? str_repeat('★', $state) . str_repeat('☆', 5 - $state) : '')
                    ->sortable(),

                TextColumn::make('quote')->label('Testimonio')->limit(60)->toggleable(),

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
