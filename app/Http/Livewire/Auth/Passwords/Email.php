<?php

namespace App\Http\Livewire\Auth\Passwords;

use Livewire\Component;
use Illuminate\Support\Facades\Password;

use WireUi\Traits\Actions;
class Email extends Component
{
    use Actions;
    /** @var string */
    public $email;

    /** @var string|null */
    public $emailSentMessage = false;

    public function sendResetPasswordLink()
    {
        $this->validate([
            'email' => ['required', 'email'],
        ]);

        $response = $this->broker()->sendResetLink(['email' => $this->email]);

        if ($response == Password::RESET_LINK_SENT) {
            $this->emailSentMessage = trans($response);

            $this->dialog()->success(
                $title = 'เราได้ส่งอีเมลล์เพื่อการกู้คืนรหัสผ่านเรียบร้อย',
                $description = 'เราได้ส่งอีเมลล์เพื่อการกู้คืนรหัสผ่านเรียบร้อย <br>กรุณาตรวจสอบอีเมลล์ของท่าน <br>เพื่อดำเนินการกู้คืนรหัสผ่าน <br>หากไม่ได้รับอีเมลล์ กรุณาติดต่อเจ้าหน้าที่ที่เกี่ยวข้อง'
            );
            return;
        }

        $this->addError('email', trans($response));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    public function render()
    {
        return view('livewire.auth.passwords.email')->extends('layouts.auth');
    }
}
