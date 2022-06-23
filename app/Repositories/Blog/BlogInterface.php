<?php

namespace App\Repositories\Blog;

interface BlogInterface
{
    /**
     * Get all blogs
     *
     * @param string $search
     * @param int $limit
     * @param string $by
     * @param string $order
     * @param string $status
     * @param string $aditional
     * @param int $page
     * @return mixed
     */
    public function all(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc');

    /**
     * Get blog detail
     *
     * @param int $id
     * @param string $userId
     * @return mixed
     */
    public function detail(Int $id, String $user_id);

    /**
     * Get blog detail
     *
     * @param int $id
     * @param string $status
     * @return mixed
     */
    public function get(Int $id, String $status = '');

    /**
     * Add blog
     * 
     * @param array $data
     * @return mixed
     */
    public function add(array $data);

    /**
     * Delete blog
     * 
     * @param int $id
     * @return mixed
     */
    public function delete(Int $id);

    /**
     * Update blog
     * 
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, Int $id);
    /**
     * Like or unlike blog
     *
     * @param Request $request
     * @return mixed
     */
    public function syncLikeUnlike(Int $blog_id, String $customer_id);

    /**
     * Sync tag
     * @param Int $blog_id
     * @param Int $tag_id
     * @return mixed
     */
    public function syncTag(Int $tag_id, Int $blog_id);

    /**
     * Sync photo
     * @param Int $blog_id
     * @param String $src
     * @return mixed
     */
    public function syncPhoto(String $src, Int $blog_id);

    /**
     * delete all photo
     * @param Int $blog_id
     * @return mixed
     */
    public function clearPhoto(Int $blog_id);

    /**
     * Get Total blog
     * @return Int
     */
    public function total(): Int;

    /**
     * Upload image
     * @param String $src
     * @param Int $blog_id
     * @return void
     */
    public function imageUpload(String $src, Int $blog_id);

    /**
     * Delete photo
     * @param Int $id
     * @return void
     */
    public function deletePhoto(Int $id);

    /**
     * Change position photo
     * @param Int $id
     * @param Int $position
     * @return void
     */
    public function changeImagePosition(Int $id, Int $position);

    public function getAll(Int $limit = 10, $tag_id);
}
