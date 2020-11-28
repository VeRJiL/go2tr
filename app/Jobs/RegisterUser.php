<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RegisterUser implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    private array $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $newUser = User::create([
            'phone_number' => $this->request['phone_number'] ?? null,
            'password' => Hash::make($this->request['password']),
            'email' => $this->request['email'] ?? null,
        ]);

        if ($newUser->phone_number) {
            SendConfirmationSms::dispatch($newUser);
        } else {
            SendConfirmationEmail::dispatch($newUser);
        }
    }
}
