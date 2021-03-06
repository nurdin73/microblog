<?php

namespace App\Repositories\Blog;

use App\Models\Blog;
use App\Models\BlogPhoto;
use App\Models\BlogTag;
use App\Traits\ImageOptimize;
use App\Traits\Shopify;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class BlogRepository implements BlogInterface
{
  use ImageOptimize, Shopify;
  public function all(String $search = '', Int $limit = 10, String $by = 'created_at', String $order = 'desc', String $status = '', $additional_info = '')
  {
    $blogs = Blog::select('*');
    if ($search != '') {
      $blogs = $blogs->where('title', 'like', '%' . $search . '%');
    }
    if ($status != '') {
      $blogs = $blogs->where('status', $status);
    }
    if ($additional_info != '') {
      $additional_info = explode(',', $additional_info);
      foreach ($additional_info as $info) {
        if ($info == 'likes') {
          $blogs = $blogs->withCount(['likes' => function ($query) {
            $query->where('status', true);
          }]);
        } else {
          if ($info == 'photos') {
            $blogs = $blogs->with(['photos' => function ($q) {
              $q->orderBy('position', 'asc');
            }]);
          } else {
            $blogs = $blogs->with($info);
          }
        }
      }
    }
    $blogs = $blogs->orderBy($by, $order)->paginate($limit);
    return $blogs;
  }

  public function get($id, $status = '')
  {
    $blog = Blog::where('id', $id)->with(['tags', 'photos' => function ($q) {
      $q->orderBy('position', 'asc');
    }]);
    if ($status != '') {
      $blog = $blog->where('status', $status);
    }
    $blog = $blog->firstOrFail();
    return $blog;
  }

  public function detail(Int $id, String $customer_id)
  {
    $blog = Blog::with(['tags', 'photos'])->withCount(['likes' => function ($query) {
      $query->where('status', true);
    }])->where('id', $id)->where('status', 'published')->first();
    $type = config('shopify.type_api');
    if (!$blog) return false;
    if ($customer_id != '') {
      $checkCustomer = $this->getCustomer($customer_id);
      if ($checkCustomer) {
        $customer_id = $type == 'storefront_api' ? $checkCustomer : $customer_id;
        $blog->setRelation('likes', $blog->likes()->where('customer_id', $customer_id)->first());
      }
    }
    return $blog;
  }

  public function add(array $data)
  {
    $blog = Blog::updateOrCreate($data);
    return $blog;
  }

  public function syncPhoto(String $src, Int $blog_id)
  {
    $blog_photo = new BlogPhoto();
    $blog_photo->src = $src;
    $blog_photo->blog_id = $blog_id;
    $blog_photo->save();
  }

  public function clearPhoto(Int $blog_id)
  {
    $checks = BlogPhoto::where('blog_id', $blog_id)->get();
    foreach ($checks as $check) {
      $this->deleteImage($check->src);
      $check->delete();
    }
  }

  public function syncTag(Int $tag_id, Int $blog_id)
  {
    $tag = BlogTag::updateOrCreate(['tag_id' => $tag_id, 'blog_id' => $blog_id]);
    return $tag;
  }

  public function update(array $data, $id)
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

  public function syncLikeUnlike(Int $blog_id, String $customer_id)
  {
    $blog = Blog::findOrFail($blog_id);
    $type = config('shopify.type_api');
    $checkCustomer = $this->getCustomer($customer_id);
    if (!$checkCustomer) return false;
    $check = $blog->likes()->where('customer_id', $type == 'storefront_api' ? $checkCustomer : $customer_id)->first();
    if ($check) {
      if ($check->status) {
        $blog->likes()->where('customer_id', $type == 'storefront_api' ? $checkCustomer : $customer_id)->update([
          'status' => false
        ]);
        $message = "Blog $blog->title has been disliked";
      } else {
        $blog->likes()->where('customer_id', $type == 'storefront_api' ? $checkCustomer : $customer_id)->update([
          'status' => true
        ]);
        $message = "Blog $blog->title has been liked";
      }
    } else {
      $blog->likes()->create([
        'customer_id' => $type == 'storefront_api' ? $checkCustomer : $customer_id,
        'blog_id' => $blog_id,
        'status' => true
      ]);
      $message = "Blog $blog->title has been liked";
    }
    return $message;
  }

  public function total(): Int
  {
    return Blog::count();
  }

  public function imageUpload(String $src, Int $blog_id)
  {
    $blog = Blog::findOrFail($blog_id);
    $checkOrderLast = BlogPhoto::where('blog_id', $blog_id)->orderBy('position', 'desc')->value('position') ?? 0;
    $image = BlogPhoto::create([
      'src' => $src,
      'blog_id' => $blog_id,
      'position' => $checkOrderLast + 1
    ]);
  }

  public function deletePhoto(Int $id)
  {
    $photo = BlogPhoto::findOrFail($id);
    $blogId = $photo->blog_id;
    $this->deleteImage($photo->src);
    $photo->delete();
    $restructure = BlogPhoto::where('blog_id', $blogId)->orderBy('position', 'asc')->get();
    $i = 1;
    foreach ($restructure as $restructure) {
      $restructure->update([
        'position' => $i
      ]);
      $i++;
    }
  }

  public function changeImagePosition(Int $id, Int $position)
  {
    $photo = BlogPhoto::findOrFail($id);
    $photo->position = $position;
    $photo->save();
  }

  public function getAll(Int $limit = 10, $tag_id = null)
  {
    if ($tag_id) {
      return Blog::whereHas('tags', function (Builder $q) use ($tag_id) {
        $q->where('tags.id', $tag_id);
      })->with('tags', 'photos')->take($limit)->orderBy('posted_at', 'desc')->get();
    }
    return Blog::take($limit)->with('tags', 'photos')->orderBy('posted_at', 'desc')->get();
  }

  public function getBlogLikedByUser($id)
  {
    $search = request()->search ?? '';
    $limit = request()->limit ?? 10;
    $orderBy = request()->orderBy ?? 'posted_at';
    $sortBy = request()->sortBy ?? 'desc';
    $type = config('shopify.type_api');
    $checkCustomer = $this->getCustomer($id);
    if (!$checkCustomer) return false;
    $customerId = $type == 'storefront_api' ? $checkCustomer : $id;
    $results = Blog::whereHas('likes', function (Builder $q) use ($customerId) {
      return $q->where('customer_id', $customerId)->where('status', 1);
    });
    if ($search != '') {
      $results = $results->where('title', 'like', "%$search%");
    }
    $results = $results->orderBy($orderBy, $sortBy)->paginate($limit);
    return $results;
  }
}
