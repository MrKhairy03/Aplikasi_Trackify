<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\ActivityLogger;

class LogLoginActivity
{
    public function handle(Login $event): void
    {
        ActivityLogger::log('login');
    }
}
