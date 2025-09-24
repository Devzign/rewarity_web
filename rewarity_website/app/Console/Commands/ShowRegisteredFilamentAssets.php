<?php

namespace App\Console\Commands;

use Filament\Support\Facades\FilamentAsset;
use Illuminate\Console\Command;

class ShowRegisteredFilamentAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:show-registered-filament-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Registered Filament styles:');
        foreach (FilamentAsset::getStyles() as $style) {
            $this->line('- '.$style->getId().' ('.$style->getHref().')');
        }

        $this->line('');

        $this->info('Registered Filament themes:');
        foreach (FilamentAsset::getThemes() as $theme) {
            $this->line('- '.$theme->getId().' ('.$theme->getHref().')');
        }
    }
}
