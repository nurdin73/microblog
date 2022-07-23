<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Repositories\Profile\ProfileRepository;
use App\Traits\Shopify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'access_token_user' => 'required|string'
        ]);
        $access_token_user = $request->access_token_user;
        $type = config('shopify.type_api');
        $checkCustomer = $this->getCustomer($access_token_user);
        if (!$checkCustomer) return response(['message' => "Account customer id not found"], 404);
        $customerId = $type == 'storefront_api' ? $checkCustomer : $access_token_user;
        $result = $this->profileRepository->getProfile($customerId);
        if (!$result) return response(['message' => 'Profile not found. please add first']);
        return new ProfileResource($result);
    }

    public function updateOrCreate(Request $request)
    {
        $data = $this->validate($request, [
            'birthDate' => 'required|date',
            'gender' => 'required|in:L,P',
            'access_token_user' => 'required',
        ]);
        $access_token_user = $request->access_token_user;
        $preferences = $request->preferences ?? [];
        $type = config('shopify.type_api');
        $checkCustomer = $this->getCustomer($access_token_user);
        if (!$checkCustomer) return response(['message' => "Account customer id not found"], 404);
        $data['account_id'] = $type == 'storefront_api' ? $checkCustomer : $access_token_user;
        DB::beginTransaction();
        try {
            $send = $this->profileRepository->updateProfile($data);
            $this->profileRepository->deletePreferences($send->id);
            foreach ($preferences as $preverence) {
                $this->profileRepository->syncPreference($send->id, $preverence);
            }
            DB::commit();
            return response(['message' => 'Profile has been updated']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['message' => $e->getMessage()], 500);
        }
    }
}
