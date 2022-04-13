<?php
namespace App\Repositories;

use App\Models\Blog;
use App\Models\BlogPhoto;
use App\Models\BlogTag;
use Illuminate\Support\Facades\Log;

class BlogRepository
{
  public function all(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc', String $status = '', $additional_info = '')
  {
    $blogs = Blog::select('*');
    if($search != '') {
      $blogs = $blogs->where('title', 'like', '%'.$search.'%');
    }
    if($status != '') {
      $blogs = $blogs->where('status', $status);
    }
    if($additional_info != '') {
      $additional_info = explode(',', $additional_info);
      foreach($additional_info as $info) {
        if($info == 'likes') {
          $blogs = $blogs->withCount(['likes' => function($query) {
            $query->where('status', true);
          }]);
        } else {
          $blogs = $blogs->with($info);
        }
      }
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

  public function detail($id, $user_id)
  {
    $blog = Blog::with(['tags', 'photos'])->withCount(['likes' => function($query) { $query->where('status', true); }])->where('id', $id)->where('status', 'published')->first();
    if(!$blog) return false;
    if($user_id != '') {
      Log::info("masuk sini");
      $blog->setRelation('likes', $blog->likes()->where('shopify_id', $user_id)->first());
    }
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

  public function syncLikeUnlike(Int $blog_id, String $shopify_id)
  {
    $blog = Blog::findOrFail($blog_id);
    $check = $blog->likes()->where('shopify_id', $shopify_id)->first();
    if($check) {
      $blog->likes()->where('shopify_id', $shopify_id)->update([
        'status' => false
      ]);
    } else {
      $blog->likes()->create(['shopify_id' => $shopify_id]);
    }
    return $blog;
  }
}