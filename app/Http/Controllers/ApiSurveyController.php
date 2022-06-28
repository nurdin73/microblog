<?php

namespace App\Http\Controllers;

use App\Http\Resources\SurveyResource;
use App\Repositories\Survey\SurveyRepository;
use App\Traits\Shopify;
use Illuminate\Http\Request;

class ApiSurveyController extends Controller
{
    use Shopify;
    protected $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'access_token_user' => 'required|string',
            'weight' => 'required|integer',
            'height' => 'required|integer',
            'result' => 'required|integer',
            'answers' => 'required|array'
        ]);

        try {
            $data = $request->only(['weight', 'height', 'result', 'answers']);
            $accessToken = $request->access_token_user;
            $type = config('shopify.type_api');
            $checkCustomer = $this->getCustomer($accessToken);
            if (!$checkCustomer) return response(['message' => "Account customer id not found"], 404);
            $data['account_id'] = $type == 'storefront_api' ? $checkCustomer : $accessToken;
            $this->surveyRepository->store($data);
            return response(['message' => "Survey success added"]);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request)
    {
        $this->validate($request, [
            'access_token_user' => 'required'
        ]);
        $accessToken = $request->access_token_user;
        $type = config('shopify.type_api');
        $checkCustomer = $this->getCustomer($accessToken);
        if (!$checkCustomer) return response(['message' => "Account customer id not found"], 404);
        $accountId = $type == 'storefront_api' ? $checkCustomer : $accessToken;
        $results = $this->surveyRepository->show($accountId);
        return SurveyResource::collection($results);
    }

    public function latest(Request $request)
    {
        $this->validate($request, [
            'access_token_user' => 'required'
        ]);
        $accessToken = $request->access_token_user;
        $type = config('shopify.type_api');
        $checkCustomer = $this->getCustomer($accessToken);
        if (!$checkCustomer) return response(['message' => "Account customer id not found"], 404);
        $accountId = $type == 'storefront_api' ? $checkCustomer : $accessToken;
        $result = $this->surveyRepository->latest($accountId);
        return new SurveyResource($result);
    }
}
