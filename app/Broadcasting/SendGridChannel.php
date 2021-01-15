<?php

namespace App\Broadcasting;

use App\Notifications\SendGridNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use SendGrid\Mail\Mail;
use SendGrid\Mail\TypeException;
use SendGrid\Response;

class SendGridChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $email = $notifiable->routeNotificationForSendGrid();
        if ($notification instanceof SendGridNotification) {
            if (app()->environment('production')) {
                $this->sendMailViaSendGrid($email, $notification->subject(),
                    $notification->content(), $notification->contentHtml());
            }
            $context = [
                'subject' => $notification->subject(),
                'content' => $notification->content(),
                'contentHtml' => $notification->contentHtml(),
            ];
            Log::debug('SendGridChannel', $context);
            error_log(json_encode($context));
        }
    }

    /**
     * Send mail via SendGrid.
     * https://sendgrid.com
     *
     * @param String $toEmail
     * @param String $subject
     * @param String $plainContent
     * @param String $htmlContent
     * @return Response
     */
    public function sendMailViaSendGrid(String $toEmail, String $subject, String $plainContent, String $htmlContent)
    {
        $email = new Mail();
        try {
            $email->setFrom(env('SEND_GRID_FROM_EMAIL'), env('SEND_GRID_FROM_NAME'));
        } catch (TypeException $e) {
        }
        $email->setSubject("$subject");
        $email->addTo($toEmail);
        $email->addContent("text/plain", $plainContent);
        $email->addContent("text/html", $htmlContent);
        $sendGrid = new \SendGrid(env('SEND_GRID_API_KEY'));
        return $sendGrid->send($email);
    }
}
