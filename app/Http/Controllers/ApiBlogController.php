<?php

namespace App\Http\Controllers;

use App\Repositories\BlogRepository;
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
        $data = $this->blogRepository->all($search, $limit, $by, $order, 'published');
        return response()->json($data);
    }
    // for api
    public function detail($id)
    {
        $userId = request()->query('userKey', '');
        $data = $this->blogRepository->detail($id, $userId);
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function likeUnlike(Request $request)
    {
        $data = $request->validate([
            'blog_id' => 'required|integer',
            'shopify_id' => 'required|integer',
        ]);
        $sync = $this->blogRepository->syncLikeUnlike($data['blog_id'], $data['shopify_id']);
        return response()->json([
            'status' => 'success',
            'message' => 'Like/Unlike successfully',
            'data' => $sync
        ]);
    }
}
