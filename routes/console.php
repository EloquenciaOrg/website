<?php

use Illuminate\Support\Facades\Schedule;


Schedule::command('app:ha-sync')
    ->hourly()
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/ha-sync.log'));
