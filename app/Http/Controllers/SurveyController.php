<?php

namespace App\Http\Controllers;

use App\Repositories\Survey\SurveyRepository;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    protected $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function __invoke(Request $request)
    {
        $search = $request->search ?? '';
        $data['surveys'] = $this->surveyRepository->paginate($search);
        return view('admin.surveys.index', $data);
    }
}
