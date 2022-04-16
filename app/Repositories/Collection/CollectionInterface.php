<?php
namespace App\Repositories\Collection;

interface CollectionInterface
{
  /**
   * Get all collections
   *
   * @param String $search
   * @param Int $limit
   * @param String $by
   * @param String $order
   * @param Int $page
   * @return Collection
   */
  public function paginate(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc');
  
  /**
   * Get All collections without pagination
   * @param Bool $status
   * @param String $search
   * @param mixed $limit
   * @return Collection
   */
  public function all(Bool $status = false, String $search, String $limit = '');

  /**
   * Get collection detail
   *
   * @param Int $id
   * @return Collection
   */
  public function get(Int $id);
  
  /**
   * Add collection
   * 
   * @param array $data
   * @return Collection
   */
  public function add(Array $data);

  /**
   * Update collection
   * @param Int $id
   * @param array $data
   * @return Collection
   */
  public function update(Int $id, Array $data);

  /**
   * Delete collection
   * @param Int $id
   * @return Collection
   */
  public function delete(Int $id);

  /**
   * Get Total collection
   * @return Int
   */
  public function total();
}