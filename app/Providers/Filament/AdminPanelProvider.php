<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use VitalSaaS\VitalAccess\Filament\Resources\AccessRoleResource;
use VitalSaaS\VitalAccess\Filament\Resources\AccessPermissionResource;
use VitalSaaS\VitalAccess\Filament\Resources\AccessModuleResource;
use VitalSaaS\VitalAccess\Filament\Widgets\VitalAccessStatsWidget;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsHeroSectionResource;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsServiceResource;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsContactSubmissionResource;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
                VitalAccessStatsWidget::class,
            ])
            ->resources([
                // VitalAccess Resources
                AccessRoleResource::class,
                AccessPermissionResource::class,
                AccessModuleResource::class,

                // VitalCMS Resources
                CmsHeroSectionResource::class,
                CmsServiceResource::class,
                CmsContactSubmissionResource::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}