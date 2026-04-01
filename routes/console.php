<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('auracampus:setup-recurring-stubs', function () {
    $this->info('Recurring task stubs are available via auracampus:run-recurring-tasks');
})->purpose('Check recurring scheduler availability');

Schedule::command('auracampus:run-recurring-tasks')->everyFiveMinutes();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
