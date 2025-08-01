<?php

namespace App\Jobs;

use App\Models\Announcement;
use App\Models\User;
use App\Models\Student;
use App\Models\ParentUser;
use App\Mail\AnnouncementMail;  
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Support\Facades\Mail;


class SendAnnouncementEmails implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected Announcement $announcement;
    /**
     * Create a new job instance.
     */
    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $recipients = collect();

        if ($this->announcement->target === 'students') {
            $recipients = Student::where('status', 1)->whereNotNull('email')->get();
        } elseif ($this->announcement->target === 'parents') {
            $recipients = ParentUser::whereNotNull('email')->get();
        } elseif ($this->announcement->target === 'students_and_parents') {
            $students = Student::where('status', 1)->whereNotNull('email')->get();
            $parents = ParentUser::whereNotNull('email')->get();
            $recipients = $students->merge($parents);
        }

        foreach ($recipients as $user) {
            Mail::to($user->email)->queue(new AnnouncementMail($this->announcement, $user));
        }
    }
}
