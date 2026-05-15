<?php

namespace App\Filament\Resources\Stats\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Contenido')
                    ->schema([
                        TextInput::make('icon')
                            ->label('Icono')
                            ->helperText('Emoji (ej. 🌿, ⭐, ✅)')
                            ->maxLength(10),

                        TextInput::make('value')
                            ->label('Valor')
                            ->required()
                            ->placeholder('+150, 10 años, 100%...')
                            ->maxLength(50),

                        TextInput::make('label')
                            ->label('Etiqueta')
                            ->required()
                            ->placeholder('Proyectos completados, Años de experiencia...')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Configuración')
                    ->schema([
                        Toggle::make('is_active')->label('Activo')->default(true),
                        TextInput::make('sort_order')->label('Orden')->numeric()->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
