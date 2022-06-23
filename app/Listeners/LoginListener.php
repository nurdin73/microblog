<?php

namespace App\Listeners;

use App\Models\ApiToken;
use App\Traits\Helper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class LoginListener
{
    use Helper;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $token = $this->getToken(json_encode($event->user));
        $checkApiToken = ApiToken::where('user_id', $event->user->id)->first();
        if (!$checkApiToken) {
            ApiToken::create([
                'user_id' => $event->user->id,
                'sort_token' => Str::uuid(),
                'token' => $token
            ]);
        }
    }
}
