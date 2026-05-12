<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources;

use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use VitalSaaS\VitalCMSMinimal\Models\CmsService;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsServiceResource\Pages;

class CmsServiceResource extends Resource
{
    protected static ?string $model = CmsService::class;

    // protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Servicios';

    protected static ?string $modelLabel = 'Servicio';

    protected static ?string $pluralModelLabel = 'Servicios';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Schemas\Components\Section::make('Información Básica')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('short_description')
                            ->label('Descripción Corta')
                            ->helperText('Para tarjetas de servicio')
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description')
                            ->label('Descripción Completa')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Schemas\Components\Section::make('Precio y Categoría')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Precio')
                            ->helperText('Ej: "Desde $500", "$200/mes", "Consultar"')
                            ->placeholder('Desde $500'),

                        Forms\Components\TextInput::make('price_description')
                            ->label('Descripción del Precio')
                            ->helperText('Ej: "por proyecto", "mensual", "según diagnóstico"')
                            ->placeholder('por proyecto'),

                        Forms\Components\Select::make('category')
                            ->label('Categoría')
                            ->options(CmsService::getCategories())
                            ->searchable(),

                        Forms\Components\TextInput::make('icon')
                            ->label('Icono')
                            ->helperText('Emoji o clase de icono')
                            ->placeholder('🌿'),
                    ])
                    ->columns(2),

                Schemas\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Imagen del Servicio')
                            ->image()
                            ->directory(config('vitalcms.services.default_image_path', 'services'))
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),

                Schemas\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\Toggle::make('featured')
                            ->label('Destacado')
                            ->helperText('Mostrar en página principal')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->helperText('Orden de visualización (menor número = primero)'),
                    ])
                    ->columns(3),

                Schemas\Components\Section::make('Características del Servicio')
                    ->schema([
                        Forms\Components\KeyValue::make('meta_data')
                            ->label('Datos Adicionales')
                            ->helperText('Features, SEO, información extra en formato JSON')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Imagen')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder-service.jpg')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('icon')
                    ->label('Icono')
                    ->formatStateUsing(fn (string $state): string => $state ?: '🌿'),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Categoría')
                    ->formatStateUsing(fn (?string $state): string =>
                        CmsService::getCategories()[$state] ?? ucfirst($state ?? 'Sin categoría')
                    )
                    ->colors([
                        'primary' => 'diseño',
                        'success' => 'mantenimiento',
                        'warning' => 'paisajismo',
                        'info' => 'instalacion',
                        'secondary' => 'consulta',
                        'danger' => 'especializado',
                    ]),

                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money('MXN', divideBy: 1)
                    ->formatStateUsing(fn (?string $state): string => $state ?: 'Consultar'),

                Tables\Columns\IconColumn::make('featured')
                    ->label('Destacado')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoría')
                    ->options(CmsService::getCategories()),

                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Destacado')
                    ->placeholder('Todos')
                    ->trueLabel('Destacados')
                    ->falseLabel('No destacados'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Estado')
                    ->placeholder('Todos')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos'),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
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
            'index' => Pages\ListCmsServices::route('/'),
            'create' => Pages\CreateCmsService::route('/create'),
            'view' => Pages\ViewCmsService::route('/{record}'),
            'edit' => Pages\EditCmsService::route('/{record}/edit'),
        ];
    }
}