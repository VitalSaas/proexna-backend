<?php

namespace VitalSaaS\VitalCMSMinimal\Filament\Resources;

use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use VitalSaaS\VitalCMSMinimal\Models\CmsHeroSection;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsHeroSectionResource\Pages;

class CmsHeroSectionResource extends Resource
{
    protected static ?string $model = CmsHeroSection::class;

    // protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Hero Sections';

    protected static ?string $modelLabel = 'Hero Section';

    protected static ?string $pluralModelLabel = 'Hero Sections';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Schemas\Components\Section::make('Información Principal')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('Subtítulo')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Schemas\Components\Section::make('Imagen Principal')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_image')
                            ->label('Imagen del Hero')
                            ->image()
                            ->directory(config('vitalcms.hero_sections.image_upload_path', 'hero-sections'))
                            ->imageEditor()
                            ->helperText('Imagen principal del hero section')
                            ->columnSpan(2),

                        Forms\Components\Select::make('image_position')
                            ->label('Posición de Imagen')
                            ->options([
                                'background' => 'Fondo completo',
                                'left' => 'Izquierda',
                                'right' => 'Derecha',
                                'center' => 'Centro',
                                'none' => 'Sin imagen',
                            ])
                            ->default('background')
                            ->reactive(),

                        Forms\Components\Select::make('content_position')
                            ->label('Posición del Contenido')
                            ->options([
                                'center' => 'Centro',
                                'left' => 'Izquierda',
                                'right' => 'Derecha',
                                'top-left' => 'Superior Izquierda',
                                'top-right' => 'Superior Derecha',
                                'bottom-left' => 'Inferior Izquierda',
                                'bottom-right' => 'Inferior Derecha',
                            ])
                            ->default('center'),

                        Forms\Components\TextInput::make('content_width')
                            ->label('Ancho del Contenido (%)')
                            ->numeric()
                            ->default(50)
                            ->suffix('%')
                            ->minValue(20)
                            ->maxValue(100)
                            ->helperText('Porcentaje del ancho que ocupará el contenido'),
                    ])
                    ->columns(2),

                Schemas\Components\Section::make('Gradiente y Efectos')
                    ->schema([
                        Forms\Components\Select::make('gradient_position')
                            ->label('Posición del Gradiente')
                            ->options([
                                'none' => 'Sin gradiente',
                                'top' => 'Superior',
                                'bottom' => 'Inferior',
                                'left' => 'Izquierda',
                                'right' => 'Derecha',
                                'center' => 'Centro (radial)',
                            ])
                            ->default('none')
                            ->reactive(),

                        Forms\Components\TextInput::make('gradient_start_color')
                            ->label('Color Inicial')
                            ->helperText('Ej: #000000, rgba(0,0,0,0.8)')
                            ->visible(fn (callable $get) => $get('gradient_position') !== 'none')
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $this->updateGradientSettings($set, $get);
                            }),

                        Forms\Components\TextInput::make('gradient_end_color')
                            ->label('Color Final')
                            ->helperText('Ej: #ffffff, rgba(255,255,255,0)')
                            ->visible(fn (callable $get) => $get('gradient_position') !== 'none')
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $this->updateGradientSettings($set, $get);
                            }),

                        Forms\Components\TextInput::make('gradient_start_opacity')
                            ->label('Opacidad Inicial (%)')
                            ->numeric()
                            ->default(100)
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100)
                            ->visible(fn (callable $get) => $get('gradient_position') !== 'none')
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $this->updateGradientSettings($set, $get);
                            }),

                        Forms\Components\TextInput::make('gradient_end_opacity')
                            ->label('Opacidad Final (%)')
                            ->numeric()
                            ->default(0)
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100)
                            ->visible(fn (callable $get) => $get('gradient_position') !== 'none')
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $this->updateGradientSettings($set, $get);
                            }),

                        Forms\Components\KeyValue::make('image_effects')
                            ->label('Efectos de Imagen')
                            ->helperText('Filtros CSS como blur, brightness, contrast, etc.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Schemas\Components\Section::make('Configuración de Fondo (Alternativa)')
                    ->schema([
                        Forms\Components\Select::make('background_type')
                            ->label('Tipo de Fondo')
                            ->options([
                                'image' => 'Imagen',
                                'video' => 'Video',
                                'gradient' => 'Gradiente',
                                'color' => 'Color Sólido',
                            ])
                            ->default('gradient')
                            ->reactive(),

                        Forms\Components\FileUpload::make('background_image')
                            ->label('Imagen de Fondo')
                            ->image()
                            ->directory(config('vitalcms.hero_sections.image_upload_path', 'hero-sections'))
                            ->visible(fn (callable $get) => $get('background_type') === 'image'),

                        Forms\Components\TextInput::make('background_video')
                            ->label('URL del Video')
                            ->url()
                            ->visible(fn (callable $get) => $get('background_type') === 'video'),

                        Forms\Components\KeyValue::make('background_settings')
                            ->label('Configuración de Fondo')
                            ->helperText('Configuraciones adicionales como gradientes, overlays, etc.')
                            ->columnSpanFull(),

                        Forms\Components\Select::make('layout')
                            ->label('Diseño (Legacy)')
                            ->options([
                                'centered' => 'Centrado',
                                'left' => 'Izquierda',
                                'right' => 'Derecha',
                                'split' => 'Dividido',
                            ])
                            ->default('centered')
                            ->helperText('Usar mejor "Posición del Contenido" arriba'),

                        Forms\Components\TextInput::make('height')
                            ->label('Altura (px)')
                            ->numeric()
                            ->default(500)
                            ->suffix('px'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),

                Schemas\Components\Section::make('Botones de Acción')
                    ->schema([
                        Forms\Components\Repeater::make('buttons')
                            ->label('Botones')
                            ->schema([
                                Forms\Components\TextInput::make('text')
                                    ->label('Texto del Botón')
                                    ->required()
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('url')
                                    ->label('URL/Enlace')
                                    ->required()
                                    ->columnSpan(2),

                                Forms\Components\Select::make('type')
                                    ->label('Tipo')
                                    ->options([
                                        'primary' => 'Primario',
                                        'secondary' => 'Secundario',
                                        'outline' => 'Contorno',
                                    ])
                                    ->default('primary')
                                    ->columnSpan(1),

                                Forms\Components\Select::make('action')
                                    ->label('Acción')
                                    ->options([
                                        'link' => 'Enlace',
                                        'scroll' => 'Desplazar',
                                        'call' => 'Llamar',
                                        'whatsapp' => 'WhatsApp',
                                        'email' => 'Email',
                                    ])
                                    ->default('link')
                                    ->columnSpan(1),
                            ])
                            ->columns(4)
                            ->maxItems(3)
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['text'] ?? null),
                    ])
                    ->columnSpanFull(),

                Schemas\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->helperText('Orden de visualización (menor número = primero)'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Subtítulo')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\BadgeColumn::make('background_type')
                    ->label('Tipo de Fondo')
                    ->colors([
                        'primary' => 'gradient',
                        'success' => 'image',
                        'warning' => 'video',
                        'secondary' => 'color',
                    ]),

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
                Tables\Filters\SelectFilter::make('background_type')
                    ->label('Tipo de Fondo')
                    ->options([
                        'image' => 'Imagen',
                        'video' => 'Video',
                        'gradient' => 'Gradiente',
                        'color' => 'Color Sólido',
                    ]),

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
            'index' => Pages\ListCmsHeroSections::route('/'),
            'create' => Pages\CreateCmsHeroSection::route('/create'),
            'view' => Pages\ViewCmsHeroSection::route('/{record}'),
            'edit' => Pages\EditCmsHeroSection::route('/{record}/edit'),
        ];
    }

    /**
     * Update gradient settings based on individual fields.
     */
    protected function updateGradientSettings(callable $set, callable $get): void
    {
        $gradientSettings = [
            'start_color' => $get('gradient_start_color'),
            'end_color' => $get('gradient_end_color'),
            'start_opacity' => $get('gradient_start_opacity'),
            'end_opacity' => $get('gradient_end_opacity'),
        ];

        $set('gradient_settings', array_filter($gradientSettings));
    }
}