<?php

use App\Support\InstagramWeeklyMenuResolver;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('instagram:refresh-weekly-menu {--force-fresh : Skip cache fallback and require a newly resolved Instagram URL}', function () {
    /** @var ClosureCommand $this */
    $forceFresh = (bool) $this->option('force-fresh');

    if ($forceFresh) {
        Cache::forget(InstagramWeeklyMenuResolver::CACHE_KEY);
    }

    $result = app(InstagramWeeklyMenuResolver::class)->refreshCachedUrl(!$forceFresh);

    if (($result['source'] ?? null) === 'cache_last_success') {
        $this->warn('Instagram weekly menu URL was not freshly resolved; using cached last success.');
        $this->line('Source: '.$result['source']);
        $this->line('URL: '.$result['url']);
        $this->line('Tip: run with --force-fresh to fail instead of reusing cache.');

        return 1;
    }

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
