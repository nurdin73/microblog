<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogCollection;
use App\Http\Resources\BlogResource;
use App\Repositories\Blog\BlogRepository;
use Illuminate\Http\Request;

class ApiBlogController extends Controller
{
    protected $blogRepository;
    public function __construct(BlogRepository $blogRepository) {
        $this->blogRepository = $blogRepository;
    }

    // for api
    public function blogs()
    {
        $search = request()->query('search', '');
        $limit = request()->query('limit', 10);
        $by = request()->query('by', 'created_at');
        $order = request()->query('order', 'desc');
        $aditional = request()->query('aditional', '');
        $data = $this->blogRepository->all($search, $limit, $by, $order, 'published', $aditional);
        // return response(BlogResource::collection($data), 200);
        return new BlogCollection($data);
    }
    // for api
    public function detail($id)
    {
        $userId = request()->query('userKey', '');
        $data = $this->blogRepository->detail($id, $userId);
        if(!$data) return response(['message' => 'Blog not found'], 404);
        return response(new BlogResource($data));
    }

    public function likeUnlike(Request $request)
    {
        $data = $request->validate([
            'blog_id' => 'required|integer',
            'customer_id' => 'required|integer',
        ]);
        $sync = $this->blogRepository->syncLikeUnlike($data['blog_id'], $data['customer_id']);
        if(!$sync) return response(['message' => 'Blog or customer id not found'], 404);
        return response()->json([
            'status' => 'success',
            'message' => $sync
        ]);
    }
}
