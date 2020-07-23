<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Illuminate\Auth\Events\PasswordReset;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Listeners\PasswordResetListener;
use Tests\TestCase;

class PasswordResetListenerTest extends TestCase
{
    private PasswordResetListener $passwordResetListener;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->passwordResetListener = $this->app->make(PasswordResetListener::class);
        $this->user = factory(User::class)->create();
    }

    public function testHandle()
    {
        $oldToken = $this->user->email_token_confirmation;
        $this->passwordResetListener->handle(new PasswordReset($this->user));
        $this->user->refresh();
        $this->assertNotEquals($oldToken, $this->user->email_token_confirmation);
    }
}
