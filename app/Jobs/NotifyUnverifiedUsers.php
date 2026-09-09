<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotifyUnverifiedUsers implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::whereNull('email_verified_at')
            ->chunk(
                100,
                function ($users) {
                    foreach ($users as $user) {
                        $user->sendVerificationReminderNotification();
                    }
                }
            );
    }
}
