<?php

namespace App\Repositories\Survey;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use Exception;
use Illuminate\Support\Facades\DB;

class SurveyRepository
{
    protected $survey;
    protected $answer;
    public function __construct(Survey $survey, SurveyAnswer $surveyAnswer)
    {
        $this->survey = $survey;
        $this->answer = $surveyAnswer;
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $set = $this->survey->create($data);
            foreach ($data['answers'] as $answer) {
                $this->answer->create([
                    'survey_id' => $set->id,
                    'answer' => $answer
                ]);
            }
            DB::commit();
            return $set;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show($account_id)
    {
        return $this->survey->where('account_id', $account_id)->with('answers')->paginate(10);
    }

    public function latest($account_id)
    {
        return $this->survey->where('account_id', $account_id)->with('answers')->orderBy('created_at', 'DESC')->latest()->first();
    }

    public function paginate($search = '')
    {
        $results = $this->answer->select('answer', DB::raw("count(*) as total_answer"));
        if ($search != '') {
            $results = $results->where('answer', 'like', "%$search%");
        }
        return $results->groupBy('answer')->paginate(10);
    }
}
