<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información Básica')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título del Proyecto')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('short_description')
                            ->label('Descripción Corta')
                            ->helperText('Para tarjetas de proyecto en el listado')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->label('Descripción Completa')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Detalles del Proyecto')
                    ->schema([
                        TextInput::make('client')
                            ->label('Cliente')
                            ->maxLength(255),

                        TextInput::make('location')
                            ->label('Ubicación')
                            ->placeholder('Oaxaca, Oax.')
                            ->maxLength(255),

                        Select::make('category')
                            ->label('Categoría')
                            ->options(Project::getCategories())
                            ->searchable(),

                        DatePicker::make('completed_at')
                            ->label('Fecha de Finalización')
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(2),

                Section::make('Imágenes')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Imagen Principal')
                            ->image()
                            ->directory('projects')
                            ->imageEditor()
                            ->columnSpanFull(),

                        FileUpload::make('gallery')
                            ->label('Galería de Imágenes')
                            ->helperText('Imágenes adicionales del proyecto')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->directory('projects/gallery')
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),

                Section::make('Configuración')
                    ->schema([
                        Toggle::make('featured')
                            ->label('Destacado')
                            ->helperText('Mostrar en portada')
                            ->default(false),

                        Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),

                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->helperText('Menor número = primero'),
                    ])
                    ->columns(3),

                Section::make('Datos Adicionales')
                    ->schema([
                        KeyValue::make('meta_data')
                            ->label('Metadatos')
                            ->helperText('SEO, características, información extra')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
