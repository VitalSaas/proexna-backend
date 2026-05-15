<?php

namespace App\Filament\Resources\Prospects\Tables;

use App\Models\Prospect;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProspectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('company')
                    ->label('Empresa')
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('source')
                    ->label('Origen')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Prospect::getSources()[$state] ?? $state)
                    ->color(fn (string $state) => match ($state) {
                        'chatbot' => 'info',
                        'contact_form' => 'primary',
                        'web' => 'gray',
                        'referral' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Prospect::getStatuses()[$state] ?? $state)
                    ->color(fn (string $state) => match ($state) {
                        'new' => 'warning',
                        'contacted' => 'info',
                        'qualified' => 'primary',
                        'proposal', 'negotiation' => 'primary',
                        'won' => 'success',
                        'lost', 'archived' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('score')
                    ->label('Score')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('assignedTo.name')
                    ->label('Asignado')
                    ->placeholder('Sin asignar')
                    ->toggleable(),

                TextColumn::make('tentative_service_date')
                    ->label('Fecha tentativa')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('—')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('next_follow_up_at')
                    ->label('Seguimiento')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Recibido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(Prospect::getStatuses()),

                SelectFilter::make('source')
                    ->label('Origen')
                    ->options(Prospect::getSources()),

                SelectFilter::make('assigned_to')
                    ->label('Asignado a')
                    ->relationship('assignedTo', 'name'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                ActionGroup::make([
                    Action::make('mark_contacted')
                        ->label('Marcar contactado')
                        ->icon('heroicon-o-phone')
                        ->color('info')
                        ->visible(fn (Prospect $record) => $record->status === 'new')
                        ->action(function (Prospect $record): void {
                            $record->update(['status' => 'contacted']);
                            Notification::make()->title('Prospecto marcado como contactado')->success()->send();
                        }),

                    Action::make('mark_qualified')
                        ->label('Calificar')
                        ->icon('heroicon-o-check-badge')
                        ->color('primary')
                        ->visible(fn (Prospect $record) => in_array($record->status, ['new', 'contacted']))
                        ->action(function (Prospect $record): void {
                            $record->update(['status' => 'qualified']);
                            Notification::make()->title('Prospecto calificado')->success()->send();
                        }),

                    Action::make('mark_won')
                        ->label('Marcar ganado')
                        ->icon('heroicon-o-trophy')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Prospect $record) => ! in_array($record->status, ['won', 'archived']))
                        ->action(function (Prospect $record): void {
                            $record->update([
                                'status' => 'won',
                                'converted_at' => now(),
                            ]);
                            Notification::make()->title('Prospecto convertido')->success()->send();
                        }),

                    Action::make('mark_lost')
                        ->label('Marcar perdido')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn (Prospect $record) => ! in_array($record->status, ['won', 'lost', 'archived']))
                        ->form([
                            TextInput::make('lost_reason')
                                ->label('Razón (opcional)')
                                ->maxLength(255),
                        ])
                        ->action(function (array $data, Prospect $record): void {
                            $record->update([
                                'status' => 'lost',
                                'lost_reason' => $data['lost_reason'] ?? null,
                            ]);
                            Notification::make()->title('Prospecto marcado como perdido')->warning()->send();
                        }),
                ])
                    ->label('Estado')
                    ->icon('heroicon-o-arrow-path')
                    ->color('gray')
                    ->button(),

                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
