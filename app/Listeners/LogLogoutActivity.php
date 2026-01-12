<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Services\ActivityLogger;

class LogLogoutActivity
{
    public function handle(Logout $event): void
    {
        ActivityLogger::log('logout');
    }
}
