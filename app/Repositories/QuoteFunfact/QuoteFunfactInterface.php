<?php
namespace App\Repositories\QuoteFunfact;

interface QuoteFunfactInterface
{

  /**
   * Get all quote_funfact with paginate
   * @param String $search
   * @param Int $limit
   * @param String $by
   * @param String $order
   * @param Int $page
   * @return Collection
   */
  public function all(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc');
  
  /**
   * Add Quote or Funfact
   * @param array $data
   * @return Collection
   */
  public function add(array $data);

  /**
   * Sync Quote or Funfact tag
   * @param Int $quote_funfact_id
   * @param Int $tag_id
   * @return mixed
   */
  public function syncTag(Int $quote_funfact_id, Int $tag_id);
  /**
   * Get quote_funfact detail
   *
   * @param Int $id
   * @return Collection
   */
  public function get($id, $status = '');

  /**
   * Get Random Quote or Funfact
   * @param Int $limit
   * @return Collection
   */
  public function random($limit = '');

  /**
   * Update Quote or Funfact
   * @param array $data
   * @param Int $id
   * @return mixed
   */
  public function update(array $data, $id);

  /**
   * Delete Quote or Funfact
   * @param Int $id
   * @return mixed
   */
  public function delete($id);

  /**
   * Get Total Quote or Funfact
   * @param String $status
   * @return Int
   */
  public function total(String $type = 'quote'): Int;
}