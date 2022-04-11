<?php
namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
  public function paginate(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc')
  {
    $tags = Tag::select('*');
    if($search != '') {
      $tags = $tags->where('name', 'like', '%'.$search.'%');
    }
    $tags = $tags->orderBy($by, $order)->paginate($limit);
    return $tags;
  }

  public function all(String $search = '')
  {
    $tags = Tag::select('*');
    if($search != '') {
      $tags = $tags->where('name', 'like', '%'.$search.'%');
    }
    $tags = $tags->get();
    return $tags;
  }
}