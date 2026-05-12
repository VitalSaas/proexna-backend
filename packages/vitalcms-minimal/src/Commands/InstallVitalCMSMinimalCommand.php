<?php

namespace VitalSaaS\VitalCMSMinimal\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallVitalCMSMinimalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vitalcms:install
                            {--seed : Run database seeders after installation}
                            {--force : Force installation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install VitalCMS Minimal - CMS para Laravel + Filament';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Installing VitalCMS Minimal...');

        if (!$this->option('force') && !$this->confirm('This will install VitalCMS Minimal. Continue?')) {
            $this->info('Installation cancelled.');
            return self::FAILURE;
        }

        try {
            // 1. Publish configuration
            $this->publishConfiguration();

            // 2. Run migrations
            $this->runMigrations();

            // 3. Run seeders if requested
            if ($this->option('seed')) {
                $this->runSeeders();
            }

            // 4. Clear cache
            $this->clearCache();

            $this->displaySuccessMessage();

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Installation failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Publish configuration files.
     */
    protected function publishConfiguration(): void
    {
        $this->info('📝 Publishing configuration...');

        Artisan::call('vendor:publish', [
            '--tag' => 'vitalcms-config',
            '--force' => true,
        ]);
    }

    /**
     * Run database migrations.
     */
    protected function runMigrations(): void
    {
        $this->info('🗄️ Running database migrations...');

        Artisan::call('migrate', ['--force' => true]);
    }

    /**
     * Run database seeders.
     */
    protected function runSeeders(): void
    {
        $this->info('🌱 Running database seeders...');

        Artisan::call('db:seed', [
            '--class' => 'VitalSaaS\\VitalCMSMinimal\\Database\\Seeders\\VitalCMSMinimalSeeder',
            '--force' => true,
        ]);
    }

    /**
     * Clear application cache.
     */
    protected function clearCache(): void
    {
        $this->info('🧹 Clearing cache...');

        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
    }

    /**
     * Display success message.
     */
    protected function displaySuccessMessage(): void
    {
        $this->info('');
        $this->info('🎉 VitalCMS Minimal installed successfully!');
        $this->info('');
        $this->info('📍 Next steps:');
        $this->info('   • Configure your AdminPanelProvider');
        $this->info('   • Access admin panel at /admin');
        $this->info('   • API available at /api/cms/*');
        $this->info('');
        $this->info('📚 Documentation: https://github.com/vitalsaas/vitalcms-minimal');
    }
}