<?php
namespace App\Repositories;

use App\Models\Collection;

class CollectionRepository
{
  protected $collection;
  public function __construct(Collection $collection) {
    $this->collection = $collection;
  }

  public function all(Bool $status = false)
  {
    if($status) {
      return $this->collection->where('is_active', true)->get();
    } else {
      return $this->collection->get();
    }
  }

  public function get($id)
  {
    return $this->collection->findOrFail($id);
  }

  public function add(Array $data)
  {
    return $this->collection->updateOrCreate($data);
  }

  public function update($id, Array $data)
  {
    return $this->get($id)->update($data);
  }

  public function delete($id)
  {
    return $this->get($id)->delete();
  }
}