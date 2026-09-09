<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class RemoveUnverifiedUsers implements ShouldQueue
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
            ->where('created_at', '<=', now()->subMonth())
            ->chunkByID(100, function ($users){
                foreach($users as $user){

                    if($user -> profile)
                        {
                            Storage::disk('public')->delete(['profiles/' . $user -> profile->getSrc()]); //original file is deleted

                            $user -> profile_photo -> delete();
                        }

                    $user->delete();
                }
            });
    }
}
