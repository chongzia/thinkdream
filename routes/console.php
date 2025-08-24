<?php

use Illuminate\Support\Facades\Artisan;
use Modules\System\Support\Schedule as ScheduleTasks;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Console\Scheduling\Schedule as ScheduleConsole;

Artisan::command('inspire', function () {
    // do something
})->purpose('Display an inspiring quote')->hourly();

// 异步任务执行，使用请取消下面的注释
if (class_exists(ScheduleTasks::class)) {
    // ScheduleTasks::run(app(ScheduleConsole::class));
}

// 接口日志消费
Schedule::command('connector:log:record')->everyMinute();
