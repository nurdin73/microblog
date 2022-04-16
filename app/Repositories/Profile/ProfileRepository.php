<?php

namespace App\Repositories\Profile;

use App\Models\User;

class ProfileRepository implements ProfileInterface
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function get($id)
    {
        return $this->user->find($id);
    }

    public function update(Int $id, Array $data)
    {
        $user = $this->user->find($id);
        $user->update($data);
        return $user;
    }
}
