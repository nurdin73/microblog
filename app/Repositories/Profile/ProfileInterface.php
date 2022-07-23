<?php

namespace App\Repositories\Profile;

interface ProfileInterface
{
  /**
   * Get Detail Profile
   * @param Int $id
   * @return mixed
   */
  public function get(Int $id);

  /**
   * Update Profile
   * @param Int $id
   * @param Array $data
   * @return mixed
   */
  public function update(Int $id, array $data);

  public function getProfile($id);
}
