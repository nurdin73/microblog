<?php

namespace App\Repositories\Profile;

use App\Models\Profile;
use App\Models\User;

class ProfileRepository implements ProfileInterface
{
    protected $user;
    protected $profile;
    public function __construct(User $user, Profile $profile)
    {
        $this->user = $user;
        $this->profile = $profile;
    }

    public function get($id)
    {
        return $this->user->find($id);
    }

    public function update(Int $id, array $data)
    {
        $user = $this->user->find($id);
        $user->update($data);
        return $user;
    }

    public function getProfile($id)
    {
        return Profile::select('id', 'account_id', 'name', 'weight', 'height')->where('account_id', $id)->first();
    }

    public function updateProfile(array $data)
    {
        return Profile::updateOrCreate([
            'account_id' => $data['account_id']
        ], $data);
    }
}
