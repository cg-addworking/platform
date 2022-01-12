<?php

namespace App\Jobs\Addworking\User\User;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\User;

class UpdateProfilePicture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var user
     */
    protected $user;

    /**
     * @var picture
     */
    protected $picture;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $picture)
    {
        $this->user = $user;
        $this->picture = $picture;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = File::from($this->picture)
            ->name("/user/{$this->user->id}/picture/%uniq%-%ts%.%ext%")
            ->saveAndGet();

        $this->user->picture()->associate($file)->save();

        return $file;
    }
}
