<?php

namespace App\Notifications;

use App\Broadcasting\SendGridChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements SendGridNotification
{
    use Queueable;

    private $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
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
        return 'Reset Password Akun Personil Penghubung PME BBLK Palembang';
    }

    /**
     * Email content in text/plain format.
     *
     * @return string
     */
    public function content()
    {
        return 'Terima kasih atas partisipasi Anda. Berikut tautan yang dapat Anda gunakan ' .
            'untuk mereset password Anda di dalam sistem PME BBLK Palembang.\n' .
            $this->link() .'\n' .
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
            '<p>Terima kasih atas partisipasi Anda. Berikut tautan yang dapat Anda gunakan untuk mereset password Anda di dalam sistem PME BBLK Palembang.</p>' .
            '<p><a href="' . $this->link() . '" target="_blank">' . $this->link() . '</a></p>'.
            '<p>Dimohon untuk menjaga kerahasiaan password.<br/><br/>E-mail ini dikikrimkan oleh sistem. Mohon untuk tidak membalas e-mail ini.</p>';
    }

    private function link()
    {
        return url("/password/reset/" . $this->token);
    }
}
