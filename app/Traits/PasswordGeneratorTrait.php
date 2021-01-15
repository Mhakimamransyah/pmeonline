<?php

namespace App\Traits;

use App\User;
use Illuminate\Support\Facades\Hash;

trait PasswordGeneratorTrait
{
    use SendPasswordToMailTrait;

    /**
     * Generate password and send password to registered email.
     *
     * @param $email
     * @return null|User
     */
    public function generatePassword($email)
    {
        $user = User::where('email', '=', $email)->first();
        if ($user == null) return null;

        $email = $user->email;
        $password = str_random(12);
        $user->password = Hash::make($password);
        $user->save();

        $this->sendPasswordToMail($password, $email);

        return $password;
    }
}