<?php

namespace App\Filament\Resources\Stats;

use App\Filament\Resources\Stats\Pages\CreateStat;
use App\Filament\Resources\Stats\Pages\EditStat;
use App\Filament\Resources\Stats\Pages\ListStats;
use App\Filament\Resources\Stats\Pages\ViewStat;
use App\Filament\Resources\Stats\Schemas\StatForm;
use App\Filament\Resources\Stats\Tables\StatsTable;
use App\Models\Stat;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StatResource extends Resource
{
    protected static ?string $model = Stat::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static string|null $navigationLabel = 'Estadísticas';

    protected static string|null $modelLabel = 'Estadística';

    protected static string|null $pluralModelLabel = 'Estadísticas';

    protected static UnitEnum|string|null $navigationGroup = 'VitalCMS';

    protected static int|null $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return StatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStats::route('/'),
            'create' => CreateStat::route('/create'),
            'view' => ViewStat::route('/{record}'),
            'edit' => EditStat::route('/{record}/edit'),
        ];
    }
}
