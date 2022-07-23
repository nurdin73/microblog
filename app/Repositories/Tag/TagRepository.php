<?php
namespace App\Repositories\Tag;

use App\Models\Tag;

class TagRepository implements TagInterface
{
  protected $tag;

  public function __construct(Tag $tag) {
    $this->tag = $tag;
  }

  public function paginate(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc')
  {
    $tags = $this->tag->select('*');
    if($search != '') {
      $tags = $tags->where('name', 'like', '%'.$search.'%');
    }
    $tags = $tags->orderBy($by, $order)->paginate($limit);
    return $tags;
  }

  public function all(String $search = '')
  {
    $tags = $this->tag->select('*');
    if($search != '') {
      $tags = $tags->where('name', 'like', '%'.$search.'%');
    }
    $tags = $tags->get();
    return $tags;
  }

  public function detail(Int $id)
  {
    $tag = $this->tag->findOrFail($id);
    return $tag;
  }

  public function find($by, $value)
  {
    $tag = $this->tag->where($by, $value)->first();
    return $tag;
  }

  public function add(Array $data)
  {
    $tag = $this->tag->updateOrCreate($data);
    return $tag;
  }

  public function delete(Int $id)
  {
    $tag = $this->tag->findOrFail($id);
    $tag->delete();
    return $tag;
  }

  public function update(Int $id, Array $data)
  {
    $tag = $this->tag->findOrFail($id);
    $tag->update($data);
    return $tag;
  }
}