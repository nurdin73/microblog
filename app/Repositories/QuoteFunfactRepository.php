<?php
namespace App\Repositories;

use App\Models\QuoteFunfact;
use App\Models\QuoteFunfactTag;

class QuoteFunfactRepository
{
  public function all(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc')
  {
    $quote_funfacts = QuoteFunfact::select('*')->with('tags');
    if($search != '') {
      $quote_funfacts = $quote_funfacts->where('title', 'like', '%'.$search.'%');
    }
    $quote_funfacts = $quote_funfacts->orderBy($by, $order)->paginate($limit);
    return $quote_funfacts;
  }

  public function add(Array $data)
  {
    $quote_funfact = QuoteFunfact::updateOrCreate($data);
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
    $quote_funfact = QuoteFunfact::where('id', $id);
    if($status != '') {
      $quote_funfact = $quote_funfact->where('status', $status);
    }
    $quote_funfact = $quote_funfact->firstOrFail();
    return $quote_funfact;
  }

  public function random($limit = 10)
  {
    $quote_funfacts = QuoteFunfact::select('*')->with('tags')->where('status', 'published')->orderByRaw("RAND()")->limit($limit)->get();
    return $quote_funfacts;
  }

  public function update(Array $data, $id)
  {
    $quote_funfact = QuoteFunfact::findOrFail($id);
    $quote_funfact->update($data);
    return $quote_funfact;
  }
  
  public function delete($id)
  {
    $quote_funfact = QuoteFunfact::findOrFail($id);
    $quote_funfact->delete();
    return $quote_funfact;
  }
}