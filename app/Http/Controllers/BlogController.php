<?php

namespace App\Http\Controllers;

use App\Repositories\BlogRepository;
use App\Repositories\TagRepository;
use App\Traits\ImageOptimize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use ImageOptimize;
    protected $blogRepository;
    protected $tagRepository;

    public function __construct(BlogRepository $blogRepository, TagRepository $tagRepository) {
        $this->blogRepository = $blogRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->query('search', '');
        $limit = request()->query('limit', 10);
        $by = request()->query('by', 'created_at');
        $order = request()->query('order', 'desc');
        $data['blogs'] = $this->blogRepository->all($search, $limit, $by, $order);
        $data['search'] = $search;
        $data['limit'] = $limit;
        $data['by'] = $by;
        $data['order'] = $order;
        return view('admin.blog.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['tags'] = $this->tagRepository->all();
        return view('admin.blog.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
        ]);
        $data['slug'] = Str::slug($data['title']);
        DB::beginTransaction();
        try {
            $blog = $this->blogRepository->add($data);
            if($request->hasFile('photos')) {
                $photos = $request->file('photos');
                foreach ($photos as $photo) {
                    $filename = $this->saveImage($photo, 'blog/');
                    Log::info($filename);
                    if($filename) {
                        $this->blogRepository->syncPhoto($filename, $blog->id);
                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Failed to upload photo');
                    }
                }
            }
            if($request->has('tags')) {
                $tags = $request->input('tags');
                foreach ($tags as $tag) {
                    $this->blogRepository->syncTag($tag, $blog->id);
                }
            }
            DB::commit();
            return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.blogs.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['blog'] = $this->blogRepository->get($id);
        return view('admin.blog.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.blog.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->blogRepository->delete($id);
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully');
    }
}
