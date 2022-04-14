<?php

namespace App\Repositories;

use App\Models\QuoteFunfact;
use App\Models\QuoteFunfactTag;

class QuoteFunfactRepository
{
  protected $quote_funfact;
  public function __construct(QuoteFunfact $quote_funfact)
  {
    $this->quote_funfact = $quote_funfact;
  }
  public function all(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc')
  {
    $quote_funfacts = $this->quote_funfact->select('*')->with('tags');
    if ($search != '') {
      $quote_funfacts = $quote_funfacts->where('title', 'like', '%' . $search . '%');
    }
    $quote_funfacts = $quote_funfacts->orderBy($by, $order)->paginate($limit);
    return $quote_funfacts;
  }

  public function add(array $data)
  {
    $quote_funfact = $this->quote_funfact->updateOrCreate($data);
    return $quote_funfact;
  }

  public function syncTag(Int $quote_funfact_id, Int $tag_id)
  {
    $quote_funfact = QuoteFunfactTag::updateOrCreate([
      'quote_funfact_id' => $quote_funfact_id,
      'tag_id' => $tag_id
    ]);
    return $quote_funfact;
  }

  public function get($id, $status = '')
  {
    $quote_funfact = $this->quote_funfact->where('id', $id);
    if ($status != '') {
      $quote_funfact = $quote_funfact->where('status', $status);
    }
    $quote_funfact = $quote_funfact->firstOrFail();
    return $quote_funfact;
  }

  public function random($limit = 10)
  {
    $date = date('Y-m-d');
    $quote_funfacts = $this->quote_funfact->select('*')->with('tags')->where('status', 'published')->where('published_at', '=', $date)->orderByRaw("RAND()")->limit($limit)->get();
    return $quote_funfacts;
  }

  public function update(array $data, $id)
  {
    $quote_funfact = $this->quote_funfact->findOrFail($id);
    $quote_funfact->update($data);
    return $quote_funfact;
  }

  public function delete($id)
  {
    $quote_funfact = $this->quote_funfact->findOrFail($id);
    $quote_funfact->delete();
    return $quote_funfact;
  }

  public function total(String $type = 'quote'): Int
  {
    return $this->quote_funfact->where('type', $type)->count();
  }
}
