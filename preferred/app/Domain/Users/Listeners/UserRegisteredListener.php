<?php

namespace Preferred\Domain\Users\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Notification;
use Preferred\Domain\Users\Notifications\VerifyEmailNotification;
use Preferred\Infrastructure\Abstracts\Listener;

class UserRegisteredListener extends Listener
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('notifications');
    }

    /**
     * Handle the event.
     *
     * @param Registered $event
     * @throws \Exception
     */
    public function handle($event)
    {
        Notification::send($event->user, new VerifyEmailNotification($event->user->email_token_confirmation));
    }
}
