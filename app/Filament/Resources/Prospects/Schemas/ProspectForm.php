<?php

namespace App\Filament\Resources\Prospects\Schemas;

use App\Models\Prospect;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProspectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Datos del Prospecto')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Correo')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(50),

                        TextInput::make('company')
                            ->label('Empresa')
                            ->maxLength(255),

                        Select::make('source')
                            ->label('Origen')
                            ->options(Prospect::getSources())
                            ->default('web')
                            ->required(),

                        TextInput::make('budget_range')
                            ->label('Rango de Presupuesto')
                            ->maxLength(60),

                        DateTimePicker::make('tentative_service_date')
                            ->label('Fecha tentativa de visita / servicio')
                            ->displayFormat('d/m/Y H:i')
                            ->seconds(false),

                        Textarea::make('interest')
                            ->label('Interés / Necesidad')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Seguimiento')
                    ->schema([
                        Select::make('status')
                            ->label('Estado')
                            ->options(Prospect::getStatuses())
                            ->default('new')
                            ->required(),

                        TextInput::make('score')
                            ->label('Puntuación')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(0),

                        Select::make('assigned_to')
                            ->label('Asignado a')
                            ->relationship('assignedTo', 'name')
                            ->searchable()
                            ->preload(),

                        DateTimePicker::make('next_follow_up_at')
                            ->label('Próximo seguimiento')
                            ->displayFormat('d/m/Y H:i'),

                        DateTimePicker::make('converted_at')
                            ->label('Convertido el')
                            ->displayFormat('d/m/Y H:i'),

                        TextInput::make('lost_reason')
                            ->label('Razón de pérdida')
                            ->maxLength(255),

                        Textarea::make('notes')
                            ->label('Notas internas')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Datos del Chatbot')
                    ->schema([
                        TextInput::make('chatbot_conversation_id')
                            ->label('ID Conversación')
                            ->maxLength(120),

                        KeyValue::make('chatbot_payload')
                            ->label('Payload')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
