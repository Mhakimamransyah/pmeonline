<?php
namespace App\Traits;

trait SendMailTrait
{

    public function sendMail(String $toEmail, String $subject, String $plainContent, String $htmlContent)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("no-reply@bblkpalembang.com", "BBLK Palembang");
        $email->setSubject("$subject");
        $email->addTo($toEmail);
        $email->addContent("text/plain", $plainContent);
        $email->addContent("text/html", $htmlContent);
        $sendgrid = new \SendGrid(env('SEND_GRID_API_KEY'));
        return $sendgrid->send($email);
    }

}