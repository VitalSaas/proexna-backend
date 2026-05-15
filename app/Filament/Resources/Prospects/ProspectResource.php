<?php

namespace App\Filament\Resources\Prospects;

use App\Filament\Resources\Prospects\Pages\CreateProspect;
use App\Filament\Resources\Prospects\Pages\EditProspect;
use App\Filament\Resources\Prospects\Pages\ListProspects;
use App\Filament\Resources\Prospects\Pages\ViewProspect;
use App\Filament\Resources\Prospects\Schemas\ProspectForm;
use App\Filament\Resources\Prospects\Tables\ProspectsTable;
use App\Models\Prospect;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ProspectResource extends Resource
{
    protected static ?string $model = Prospect::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-funnel';

    protected static string|null $navigationLabel = 'Prospectos';

    protected static string|null $modelLabel = 'Prospecto';

    protected static string|null $pluralModelLabel = 'Prospectos';

    protected static UnitEnum|string|null $navigationGroup = 'CRM';

    protected static int|null $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'new')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return ProspectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProspectsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProspects::route('/'),
            'create' => CreateProspect::route('/create'),
            'view' => ViewProspect::route('/{record}'),
            'edit' => EditProspect::route('/{record}/edit'),
        ];
    }
}
