<?php

namespace App\Notifications;

interface SendGridNotification
{
    /**
     * Email subject.
     *
     * @return string
     */
    public function subject();

    /**
     * Email content in text/plain format.
     *
     * @return string
     */
    public function content();

    /**
     * Email content in HTML format.
     *
     * @return string
     */
    public function contentHtml();
}