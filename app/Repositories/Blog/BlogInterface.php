<?php
namespace App\Repositories\Blog;

interface BlogInterface
{
    public function all(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc');
    public function detail(Int $id, String $user_id);
    public function add(Array $data);
    public function delete(Int $id);
    public function update(Array $data, Int $id);
    public function syncLikeUnlike(Int $blog_id, String $customer_id);
}