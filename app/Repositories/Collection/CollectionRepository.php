<?php

namespace App\Repositories\Collection;

use App\Models\Collection;

class CollectionRepository implements CollectionInterface
{
  protected $collection;
  public function __construct(Collection $collection)
  {
    $this->collection = $collection;
  }

  public function paginate(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc')
  {
    $collections = $this->collection->select('*');
    if ($search != '') {
      $collections = $collections->where('collection_id', 'like', '%' . $search . '%');
    }
    $collections = $collections->orderBy($by, $order)->paginate($limit);
    return $collections;
  }

  public function all(Bool $status = false, String $search, String $limit = '')
  {
    $collections = $this->collection;
    if($search != '') {
      $collections = $collections->where('title', 'like', '%' . $search . '%');
    }
    if($limit != '') {
      $collections = $collections->limit($limit);
    }
    if ($status) {
      return $collections->where('is_active', true)->get();
    } else {
      return $collections->get();
    }
  }

  public function get($id)
  {
    return $this->collection->findOrFail($id);
  }

  public function add(array $data)
  {
    return $this->collection->updateOrCreate($data);
  }

  public function update($id, array $data)
  {
    return $this->get($id)->update($data);
  }

  public function delete($id)
  {
    return $this->get($id)->delete();
  }

  public function total()
  {
    return $this->collection->count();
  }
}
