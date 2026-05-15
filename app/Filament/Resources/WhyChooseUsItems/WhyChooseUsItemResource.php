<?php

namespace App\Filament\Resources\WhyChooseUsItems;

use App\Filament\Resources\WhyChooseUsItems\Pages\CreateWhyChooseUsItem;
use App\Filament\Resources\WhyChooseUsItems\Pages\EditWhyChooseUsItem;
use App\Filament\Resources\WhyChooseUsItems\Pages\ListWhyChooseUsItems;
use App\Filament\Resources\WhyChooseUsItems\Pages\ViewWhyChooseUsItem;
use App\Filament\Resources\WhyChooseUsItems\Schemas\WhyChooseUsItemForm;
use App\Filament\Resources\WhyChooseUsItems\Tables\WhyChooseUsItemsTable;
use App\Models\WhyChooseUsItem;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class WhyChooseUsItemResource extends Resource
{
    protected static ?string $model = WhyChooseUsItem::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-sparkles';

    protected static string|null $navigationLabel = 'Por qué elegirnos';

    protected static string|null $modelLabel = 'Motivo';

    protected static string|null $pluralModelLabel = 'Por qué elegirnos';

    protected static UnitEnum|string|null $navigationGroup = 'VitalCMS';

    protected static int|null $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return WhyChooseUsItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WhyChooseUsItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWhyChooseUsItems::route('/'),
            'create' => CreateWhyChooseUsItem::route('/create'),
            'view' => ViewWhyChooseUsItem::route('/{record}'),
            'edit' => EditWhyChooseUsItem::route('/{record}/edit'),
        ];
    }
}
