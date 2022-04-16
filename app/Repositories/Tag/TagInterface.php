<?php
namespace App\Repositories\Tag;
interface TagInterface
{

  /**
   * Get all tag with paginate
   * @param String $search
   * @param Int $limit
   * @param String $by
   * @param String $order
   * @param Int $page
   * @return Collection
   */
  public function paginate(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc');
  
  /**
   * Get All tag without pagination
   * @param String $search
   * @return Collection
   */
  public function all(String $search = '');

  /**
   * Get detail tag
   * @param Int $id
   * @return Collection
   */
  public function detail(Int $id);

  /**
   * Add tag
   * @param array $data
   * @return Collection
   */
  public function add(Array $data);

  /**
   * Delete tag
   * @param Int $id
   * @return mixed
   */
  public function delete(Int $id);

  /**
   * Update tag
   * @param Int $id
   * @param array $data
   * @return Collection
   */
  public function update(Int $id, Array $data);
}