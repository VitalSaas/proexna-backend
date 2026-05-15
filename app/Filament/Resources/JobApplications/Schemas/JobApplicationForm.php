<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Datos del Postulante')
                    ->schema([
                        Select::make('job_vacancy_id')
                            ->label('Vacante')
                            ->helperText('Vacío = postulación abierta (sin vacante específica)')
                            ->relationship('vacancy', 'title')
                            ->searchable()
                            ->preload(),

                        TextInput::make('name')
                            ->label('Nombre Completo')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Correo')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(50),

                        TextInput::make('city')
                            ->label('Ciudad')
                            ->maxLength(255),

                        TextInput::make('position_interest')
                            ->label('Puesto de interés')
                            ->helperText('Útil cuando la postulación es abierta')
                            ->maxLength(255),

                        Textarea::make('message')
                            ->label('Mensaje / Carta de Presentación')
                            ->rows(4)
                            ->columnSpanFull(),

                        TextInput::make('resume_path')
                            ->label('CV (ruta de archivo)')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Seguimiento Interno')
                    ->schema([
                        Select::make('status')
                            ->label('Estado')
                            ->options(JobApplication::getStatuses())
                            ->default('nuevo')
                            ->required(),

                        DateTimePicker::make('contacted_at')
                            ->label('Contactado el')
                            ->displayFormat('d/m/Y H:i'),

                        Textarea::make('internal_notes')
                            ->label('Notas Internas')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
