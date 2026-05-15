<?php

namespace App\Filament\Resources\Sectors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SectorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Contenido')
                    ->schema([
                        TextInput::make('icon')
                            ->label('Icono')
                            ->helperText('Emoji o caracter (ej. 🏨, 🏢, 🏠, 🏛️)')
                            ->maxLength(10),

                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->placeholder('Hoteles boutique, Residencial, Corporativo...')
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->label('Imagen (opcional)')
                            ->image()
                            ->directory('sectors')
                            ->imageEditor()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Configuración')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),

                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
