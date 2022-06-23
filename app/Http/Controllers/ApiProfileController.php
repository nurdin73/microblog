<?php

namespace App\Http\Controllers;

use App\Repositories\Profile\ProfileRepository;
use App\Traits\Shopify;
use Illuminate\Http\Request;

class ApiProfileController extends Controller
{
    use Shopify;
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function get(Request $request)
    {
        $this->validate($request, [
            'account_id' => 'required|string'
        ]);
        $account_id = $request->account_id;
        $type = config('shopify.type_api');
        $checkCustomer = $this->getCustomer($account_id);
        if (!$checkCustomer) return response(['message' => "Account customer id not found"], 404);
        $customerId = $type == 'storefront_api' ? $checkCustomer : $account_id;
        $result = $this->profileRepository->getProfile($customerId);
        if (!$result) return response(['message' => 'Profile not found. please add first']);
        return $result;
    }

    public function updateOrCreate(Request $request)
    {
        $data = $this->validate($request, [
            'weight' => 'required|integer',
            'height' => 'required|integer',
            'account_id' => 'required|string',
            'name' => 'required|string'
        ]);
        $account_id = $request->account_id;
        $type = config('shopify.type_api');
        $checkCustomer = $this->getCustomer($account_id);
        if (!$checkCustomer) return response(['message' => "Account customer id not found"], 404);
        $data['account_id'] = $type == 'storefront_api' ? $checkCustomer : $account_id;
        try {
            $this->profileRepository->updateProfile($data);
            return response(['message' => 'Profile has been updated']);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }
}
