<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
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
                            ->live(onBlur: true)
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->helperText('URL amigable. Se autogenera si lo dejas vacío.')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('excerpt')
                            ->label('Extracto')
                            ->helperText('Resumen breve para el listado y SEO')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Contenido')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Imagen Destacada')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Imagen Destacada')
                            ->image()
                            ->directory('posts')
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),

                Section::make('Clasificación y Autor')
                    ->schema([
                        Select::make('category')
                            ->label('Categoría')
                            ->options(Post::getCategories())
                            ->searchable(),

                        TextInput::make('author_name')
                            ->label('Autor (override)')
                            ->helperText('Si lo dejas vacío se usa el usuario asignado o "PROEXNA"')
                            ->maxLength(255),

                        Select::make('user_id')
                            ->label('Autor (usuario)')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                Section::make('Publicación')
                    ->schema([
                        Select::make('status')
                            ->label('Estado')
                            ->options(Post::getStatuses())
                            ->default('draft')
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Fecha de Publicación')
                            ->helperText('Si es futura, el post se publicará automáticamente en esa fecha')
                            ->displayFormat('d/m/Y H:i')
                            ->default(now()),
                    ])
                    ->columns(2),

                Section::make('SEO / Metadatos')
                    ->schema([
                        KeyValue::make('meta_data')
                            ->label('Metadatos')
                            ->helperText('meta_title, meta_description, keywords, etc.')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
