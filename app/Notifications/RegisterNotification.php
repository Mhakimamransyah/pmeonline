<?php

namespace App\Notifications;

use App\Broadcasting\SendGridChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RegisterNotification extends Notification implements SendGridNotification
{
    use Queueable;

    private $email, $password;

    /**
     * Create a new notification instance.
     *
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SendGridChannel::class];
    }

    /**
     * Email subject.
     *
     * @return string
     */
    public function subject()
    {
        return 'Akun Personil Penghubung PME BBLK Palembang';
    }

    /**
     * Email content in text/plain format.
     *
     * @return string
     */
    public function content()
    {
        return 'Terima kasih atas partisipasi Anda. Berikut username dan password yang dapat Anda gunakan ' .
            'untuk mengakses akun Anda di dalam sistem PME BBLK Palembang.\n' .
            'Username : ' . $this->email . '\n' . 'Password : '. $this->password .'\n' .
            'Dimohon untuk menjaga kerahasiaan password.\n\nE-mail ini dikikrimkan oleh sistem. Mohon untuk tidak membalas e-mail ini.';
    }

    /**
     * Email content in HTML format.
     *
     * @return string
     */
    public function contentHtml()
    {
        return '<h3>Akun Personil Penghubung PME BBLK Palembang</h3>' .
            '<p>Terima kasih atas partisipasi Anda. Berikut username dan password yang dapat Anda gunakan untuk mengakses akun Anda di dalam sistem PME BBLK Palembang.</p>' .
            '<p>Username : '. $this->email . '</p>' .
            '<p>Passowrd : '. $this->password . '</p>' .
            '<p>Dimohon untuk menjaga kerahasiaan password.<br/><br/>E-mail ini dikikrimkan oleh sistem. Mohon untuk tidak membalas e-mail ini.</p>';
    }
}
