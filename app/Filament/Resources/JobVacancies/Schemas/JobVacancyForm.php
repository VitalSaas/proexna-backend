<?php

namespace App\Filament\Resources\JobVacancies\Schemas;

use App\Models\JobVacancy;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobVacancyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información de la Vacante')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título del Puesto')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('short_description')
                            ->label('Descripción Corta')
                            ->helperText('Resumen breve para listados')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->label('Descripción Completa')
                            ->columnSpanFull(),

                        RichEditor::make('requirements')
                            ->label('Requisitos')
                            ->columnSpanFull(),

                        RichEditor::make('benefits')
                            ->label('Beneficios')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Detalles')
                    ->schema([
                        TextInput::make('department')
                            ->label('Departamento / Área')
                            ->placeholder('Operaciones, Diseño, Mantenimiento...')
                            ->maxLength(255),

                        TextInput::make('location')
                            ->label('Ubicación')
                            ->placeholder('Oaxaca, Oax.')
                            ->maxLength(255),

                        Select::make('employment_type')
                            ->label('Tipo de Contratación')
                            ->options(JobVacancy::getEmploymentTypes())
                            ->searchable(),

                        TextInput::make('salary_range')
                            ->label('Rango Salarial')
                            ->placeholder('A convenir / $X - $Y mensual')
                            ->maxLength(255),

                        DatePicker::make('posted_at')
                            ->label('Fecha de Publicación')
                            ->displayFormat('d/m/Y')
                            ->default(now()),

                        DatePicker::make('closes_at')
                            ->label('Fecha de Cierre')
                            ->helperText('Después de esta fecha la vacante se ocultará automáticamente')
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(2),

                Section::make('Configuración')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Activa')
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
