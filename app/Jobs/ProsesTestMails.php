<?php

namespace App\Jobs;

use App\Mail\TestingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProsesTestMails implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new job instance.
   */
  public function __construct(public $user)
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    Mail::to($this->user['email'])->send(new TestingMail($this->user));
    sleep(1);
  }
}
