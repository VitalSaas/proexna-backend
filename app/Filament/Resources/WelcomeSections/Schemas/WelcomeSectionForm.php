<?php

namespace App\Filament\Resources\WelcomeSections\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WelcomeSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Contenido')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Empresa oaxaqueña especializada en jardinería profesional')
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Texto de bienvenida')
                            ->helperText('2-3 párrafos: quiénes son, años de experiencia, qué los hace diferentes')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Imagen')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Imagen (foto del equipo o jardín)')
                            ->image()
                            ->directory('welcome')
                            ->imageEditor()
                            ->columnSpanFull(),

                        TextInput::make('image_alt')
                            ->label('Texto alternativo de la imagen')
                            ->helperText('Para accesibilidad y SEO')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Section::make('Botón secundario')
                    ->schema([
                        TextInput::make('button_text')
                            ->label('Texto del botón')
                            ->placeholder('Conoce más sobre nosotros')
                            ->maxLength(255),

                        TextInput::make('button_url')
                            ->label('URL del botón')
                            ->placeholder('/nosotros')
                            ->helperText('Ruta interna (ej. /nosotros) o URL completa')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Configuración')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Activo')
                            ->helperText('Solo la primera sección activa se muestra en el home')
                            ->default(true),

                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->helperText('Menor número = primero'),
                    ])
                    ->columns(2),
            ]);
    }
}
