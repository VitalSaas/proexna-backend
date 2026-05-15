<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Cliente')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('role')
                            ->label('Cargo / Rol')
                            ->placeholder('Cliente residencial, Director General...')
                            ->maxLength(255),

                        TextInput::make('company')
                            ->label('Empresa (opcional)')
                            ->maxLength(255),

                        FileUpload::make('image')
                            ->label('Foto del cliente')
                            ->image()
                            ->avatar()
                            ->directory('testimonials')
                            ->imageEditor(),
                    ])
                    ->columns(2),

                Section::make('Testimonio')
                    ->schema([
                        Textarea::make('quote')
                            ->label('Cita')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        Select::make('rating')
                            ->label('Calificación')
                            ->options([
                                5 => '★★★★★ (5)',
                                4 => '★★★★☆ (4)',
                                3 => '★★★☆☆ (3)',
                                2 => '★★☆☆☆ (2)',
                                1 => '★☆☆☆☆ (1)',
                            ])
                            ->default(5),
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
