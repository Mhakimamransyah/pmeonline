<?php
/**
 * Created by PhpStorm.
 * User: littleflower
 * Date: 24/09/18
 * Time: 1:26
 */

namespace App\Traits;


trait SendPasswordToMailTrait
{

    use SendMailTrait;

    public function sendPasswordToMail($password, $email)
    {
        $this->sendMail($email, 'Akun Personil Penghubung PME BBLK Palembang',
            'Terima kasih atas partisipasi Anda. Berikut username dan password yang dapat Anda gunakan 
            untuk mengakses akun Anda di dalam sistem PME BBLK Palembang.\n
            Username : ' . $email . '\n' . 'Password : '. $password .'\n'.
            'Dimohon untuk menjaga kerahasiaan password.\n\nE-mail ini dikikrimkan oleh sistem. Mohon untuk tidak membalas e-mail ini.',
            '<h3>Akun Personil Penghubung PME BBLK Palembang</h3>' .
            '<p>Terima kasih atas partisipasi Anda. Berikut username dan password yang dapat Anda gunakan untuk mengakses akun Anda di dalam sistem PME BBLK Palembang.</p>' .
            '<p>Username : '. $email . '</p>' .
            '<p>Passowrd : '. $password . '</p>');
    }

}