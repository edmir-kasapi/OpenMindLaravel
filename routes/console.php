<?php

use App\Jobs\NotifyUnverifiedUsers;
use App\Jobs\RemoveUnverifiedUsers;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new NotifyUnverifiedUsers())->mondays();
Schedule::job(new RemoveUnverifiedUsers())->daily();
