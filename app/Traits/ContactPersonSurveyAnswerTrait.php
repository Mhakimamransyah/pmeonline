<?php

namespace App\Traits;


use App\ContactPerson;

trait ContactPersonSurveyAnswerTrait
{
    /**
     * Check if contact person has answer survey.
     *
     * @param $contactPersonId
     * @return bool
     */
    public function checkIfContactPersonHasAnswerSurvey($contactPersonId)
    {
        $contactPerson = ContactPerson::findOrFail($contactPersonId);
        if (count($contactPerson->surveyAnswers) > 0) {
            return true;
        }
        return false;
    }
}