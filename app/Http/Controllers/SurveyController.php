<?php

namespace App\Http\Controllers;

use App\Survey;
use App\SurveyAnswer;
use App\SurveyOption;
use App\Traits\ParticipantControllerTraits;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    use ParticipantControllerTraits;

    public function __construct()
    {
        $this->middleware(['auth', 'participant'])->only(['showForm', 'post']);
        $this->middleware(['auth', 'admin'])->only(['administrator']);
    }

    public function showForm($id, Request $request)
    {
        $survey = Survey::find($id);
        $contact = $this->findContactPerson();
        $answered = SurveyAnswer::where('contact_person_id', '=', $contact->id)->get()->map(function ($item) {
            return $item->survey_option_id;
        });

        $data = [
            'survey' => $survey,
            'contact' => $contact,
            'answered' => $answered,
        ];

        if ($request->has('debug')) {
            return $data;
        }
        return view('participant.survey.form', $data);
    }

    public function post($id, Request $request)
    {
        $contactPersonId = $request->get('contact_person_id');
        $survey = Survey::find($id);

        SurveyAnswer::where('contact_person_id', $contactPersonId)->delete();
        foreach ($survey->questions as $question) {
            if ($request->has($question->id)) {
                SurveyAnswer::create([
                    'contact_person_id' => $contactPersonId,
                    'survey_option_id' => $request->get($question->id),
                ]);
            } else {
                return redirect()->back()->withErrors([
                    'Kuisioner dengan pertanyaan <b>' . $question->title . '</b> belum diisi.',
                ]);
            }
        }
        session()->flash('success', true);
        return redirect()->back();
    }

    public function defaultSurvey()
    {
        return redirect()->route('administrator.survey.index', ['id' => 1]);
    }

    public function index($id, Request $request)
    {
        $questions = Survey::find($id)->questions->load('options');

        $total_averages = 0;
        foreach ($questions as $question) {
            $score = 0;
            $question_count = 0;
            foreach ($question->options as $option) {
                $count = SurveyAnswer::where('survey_option_id', '=', $option->id)->count();
                $option->count = $count;
                $score += $count * $option->score;
                $question_count += $count;
            }
            $question->score = $score;
            $question->count = $question_count;
            if ($question_count == 0) {
                $average = 0;
            } else {
                $average = (double)$score / (double)$question_count;
            }
            $question->average = $average;
            $total_averages += $average;
        }

        $total_questions = $questions->count();
        if ($total_questions == 0) {
            $average_result = 0;
        } else {
            $average_result = $total_averages / $total_questions;
        }
        $data = [
            'raw' => $questions,
            'average' => $average_result,
        ];

        if ($request->has('debug')) {
            return $data;
        }
        return view('admin.survey.index', $data);
    }

}
