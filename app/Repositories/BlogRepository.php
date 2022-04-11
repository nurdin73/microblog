<?php
namespace App\Repositories;

use App\Models\Blog;
use App\Models\BlogPhoto;
use App\Models\BlogTag;

class BlogRepository
{
  public function all(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc', String $status = '')
  {
    $blogs = Blog::select('*')->with('tags');
    if($search != '') {
      $blogs = $blogs->where('title', 'like', '%'.$search.'%');
    }
    if($status != '') {
      $blogs = $blogs->where('status', $status);
    }
    $blogs = $blogs->orderBy($by, $order)->paginate($limit);
    return $blogs;
  }

  public function get($id, $status = '')
  {
    $blog = Blog::where('id', $id);
    if($status != '') {
      $blog = $blog->where('status', $status);
    }
    $blog = $blog->firstOrFail();
    return $blog;
  }

  public function add(Array $data)
  {
    $blog = Blog::updateOrCreate($data);
    return $blog;
  }

  public function syncPhoto(String $src, Int $blog_id)
  {
    $photo = BlogPhoto::updateOrCreate(['src' => $src, 'blog_id' => $blog_id]);
    return $photo;
  }

  public function syncTag(Int $tag_id, Int $blog_id)
  {
    $tag = BlogTag::updateOrCreate(['tag_id' => $tag_id, 'blog_id' => $blog_id]);
    return $tag;
  }

  public function update(Array $data, $id)
  {
    $blog = Blog::findOrFail($id);
    $blog->update($data);
    return $blog;
  }

  public function delete($id)
  {
    $blog = Blog::findOrFail($id);
    $blog->delete();
    return $blog;
  }
}