<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources;

use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use VitalSaaS\VitalCMSMinimal\Models\CmsContactSubmission;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsContactSubmissionResource\Pages;

class CmsContactSubmissionResource extends Resource
{
    protected static ?string $model = CmsContactSubmission::class;

    // protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Mensajes de Contacto';

    protected static ?string $modelLabel = 'Mensaje de Contacto';

    protected static ?string $pluralModelLabel = 'Mensajes de Contacto';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Schemas\Components\Section::make('Información del Cliente')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->disabled(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->disabled(),

                        Forms\Components\TextInput::make('phone')
                            ->label('Teléfono')
                            ->disabled(),

                        Forms\Components\TextInput::make('subject')
                            ->label('Asunto')
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('message')
                            ->label('Mensaje')
                            ->disabled()
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('service_interest')
                            ->label('Servicio de Interés')
                            ->options(CmsContactSubmission::getServiceInterests())
                            ->disabled(),
                    ])
                    ->columns(2),

                Schemas\Components\Section::make('Gestión del Mensaje')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options(CmsContactSubmission::getStatuses())
                            ->required(),

                        Forms\Components\DateTimePicker::make('read_at')
                            ->label('Fecha de Lectura')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('replied_at')
                            ->label('Fecha de Respuesta')
                            ->disabled(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Notas Internas')
                            ->helperText('Notas internas para el equipo')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Schemas\Components\Section::make('Información Técnica')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('Dirección IP')
                            ->disabled(),

                        Forms\Components\Textarea::make('user_agent')
                            ->label('User Agent')
                            ->disabled()
                            ->rows(2),

                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Fecha de Envío')
                            ->disabled(),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function ($record) {
                        return $record->subject;
                    }),

                Tables\Columns\TextColumn::make('service_interest')
                    ->label('Servicio')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string =>
                        CmsContactSubmission::getServiceInterests()[$state] ?? 'No especificado'
                    )
                    ->colors([
                        'primary' => 'diseño',
                        'success' => 'mantenimiento',
                        'warning' => 'paisajismo',
                        'info' => 'instalacion',
                        'secondary' => 'consulta',
                        'gray' => 'otro',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Estado')
                    ->formatStateUsing(fn (string $state): string =>
                        CmsContactSubmission::getStatuses()[$state] ?? $state
                    )
                    ->colors([
                        'success' => 'new',
                        'warning' => 'read',
                        'primary' => 'replied',
                        'gray' => 'archived',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enviado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record) => $record->created_at->format('d/m/Y H:i:s')),

                Tables\Columns\IconColumn::make('is_read')
                    ->label('Leído')
                    ->getStateUsing(fn ($record) => !is_null($record->read_at))
                    ->boolean()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options(CmsContactSubmission::getStatuses()),

                Tables\Filters\SelectFilter::make('service_interest')
                    ->label('Servicio de Interés')
                    ->options(CmsContactSubmission::getServiceInterests()),

                Tables\Filters\Filter::make('unread')
                    ->label('No leídos')
                    ->query(fn ($query) => $query->whereNull('read_at')),

                Tables\Filters\Filter::make('today')
                    ->label('Hoy')
                    ->query(fn ($query) => $query->whereDate('created_at', today())),

                Tables\Filters\Filter::make('this_week')
                    ->label('Esta semana')
                    ->query(fn ($query) => $query->whereBetween('created_at', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ])),
            ])
            ->actions([
                Actions\Action::make('mark_as_read')
                    ->label('Marcar como Leído')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->action(fn ($record) => $record->markAsRead())
                    ->visible(fn ($record) => !$record->isRead()),

                Actions\Action::make('mark_as_replied')
                    ->label('Marcar como Respondido')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('primary')
                    ->action(fn ($record) => $record->markAsReplied())
                    ->visible(fn ($record) => $record->isRead() && !$record->isReplied()),

                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\BulkAction::make('mark_as_read')
                        ->label('Marcar como Leídos')
                        ->icon('heroicon-o-eye')
                        ->action(fn ($records) => $records->each->markAsRead()),

                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Actualizar cada 30 segundos
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCmsContactSubmissions::route('/'),
            'view' => Pages\ViewCmsContactSubmission::route('/{record}'),
            'edit' => Pages\EditCmsContactSubmission::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        $newCount = static::getModel()::count();

        return $newCount > 0 ? 'warning' : null;
    }
}