<?php

use App\Support\InstagramWeeklyMenuResolver;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('instagram:refresh-weekly-menu', function () {
    /** @var ClosureCommand $this */
    $result = app(InstagramWeeklyMenuResolver::class)->refreshCachedUrl();

    if (!empty($result['url'])) {
        $this->info('Instagram weekly menu URL refreshed successfully.');
        $this->line('Source: '.$result['source']);
        $this->line('URL: '.$result['url']);

        return 0;
    }

    $this->warn('Instagram weekly menu URL could not be refreshed.');
    $this->line('Source: '.($result['source'] ?? 'none'));
    $this->line('Diagnostics: '.json_encode($result['diagnostics'] ?? [], JSON_UNESCAPED_SLASHES));

    return 1;
})->purpose('Refresh the cached Instagram weekly menu URL');

Schedule::command('instagram:refresh-weekly-menu')
    ->everyTwoHours()
    ->withoutOverlapping();
