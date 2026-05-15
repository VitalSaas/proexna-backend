<?php

namespace App\Filament\Resources\WelcomeSections;

use App\Filament\Resources\WelcomeSections\Pages\CreateWelcomeSection;
use App\Filament\Resources\WelcomeSections\Pages\EditWelcomeSection;
use App\Filament\Resources\WelcomeSections\Pages\ListWelcomeSections;
use App\Filament\Resources\WelcomeSections\Pages\ViewWelcomeSection;
use App\Filament\Resources\WelcomeSections\Schemas\WelcomeSectionForm;
use App\Filament\Resources\WelcomeSections\Tables\WelcomeSectionsTable;
use App\Models\WelcomeSection;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class WelcomeSectionResource extends Resource
{
    protected static ?string $model = WelcomeSection::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-hand-raised';

    protected static string|null $navigationLabel = 'Bienvenida';

    protected static string|null $modelLabel = 'Sección de Bienvenida';

    protected static string|null $pluralModelLabel = 'Secciones de Bienvenida';

    protected static UnitEnum|string|null $navigationGroup = 'VitalCMS';

    protected static int|null $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return WelcomeSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WelcomeSectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWelcomeSections::route('/'),
            'create' => CreateWelcomeSection::route('/create'),
            'view' => ViewWelcomeSection::route('/{record}'),
            'edit' => EditWelcomeSection::route('/{record}/edit'),
        ];
    }
}
