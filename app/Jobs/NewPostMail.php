<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPostNotification;

class NewPostMail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Post $post)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $followersEmails = $this->post->user->followers()->pluck('email');
        // dd($followersEmails);
        foreach ($followersEmails as $email) {
            // Here you would typically send the email notification
            // For example: Mail::to($email)->send(new NewPostNotification($this->post));
            Mail::to($email)->send(new NewPostNotification($this->post));
        }
    }
}
