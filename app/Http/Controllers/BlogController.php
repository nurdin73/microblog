<?php

namespace App\Http\Controllers;

use App\Repositories\Blog\BlogRepository;
use App\Repositories\Tag\TagRepository;
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

    public function __construct(BlogRepository $blogRepository, TagRepository $tagRepository)
    {
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
        $data['blogs'] = $this->blogRepository->all($search, $limit, $by, $order, '', 'likes');
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
            'posted_at' => 'required'
        ]);
        $data['slug'] = Str::slug($data['title']);
        DB::beginTransaction();
        try {
            $blog = $this->blogRepository->add($data);
            if ($request->hasFile('photos')) {
                $photos = $request->file('photos');
                foreach ($photos as $photo) {
                    $filename = $this->saveImage($photo, 'blog/');
                    if ($filename) {
                        $this->blogRepository->syncPhoto($filename, $blog->id);
                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Failed to upload photo');
                    }
                }
            } else {
                DB::rollBack();
                return redirect()->back()->withErrors(['photos' => 'Please upload at least one photo']);
            }
            if ($request->has('tags')) {
                $tags = $request->input('tags');
                foreach ($tags as $tag) {
                    $this->blogRepository->syncTag($tag, $blog->id);
                }
            }
            DB::commit();
            return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
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
        $data['tags'] = $this->tagRepository->all();
        $data['blog'] = $this->blogRepository->get($id);
        return view('admin.blog.edit', $data);
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
        $data = $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
            'posted_at' => 'required'
        ]);
        $data['slug'] = Str::slug($data['title']);
        DB::beginTransaction();
        try {
            $blog = $this->blogRepository->update($data, $id);
            if ($request->has('tags')) {
                $tags = $request->input('tags');
                foreach ($tags as $tag) {
                    $this->blogRepository->syncTag($tag, $blog->id);
                }
            }
            DB::commit();
            return redirect()->route('admin.blogs.index')->with('success', 'Blog update successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->blogRepository->clearPhoto($id);
        $delete = $this->blogRepository->delete($id);
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully');
    }

    public function imageUpload(Request $request)
    {
        $this->validate($request, [
            'blog_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = $request->file('image');
        $filename = $this->saveImage($image, 'blog/');
        if ($filename) {
            $this->blogRepository->imageUpload($filename, $request->input('blog_id'));
            return redirect()->back()->with('success', 'Image uploaded successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to upload image');
        }
    }

    public function imageDelete($id)
    {
        $this->blogRepository->deletePhoto($id);
        return response([
            'status' => 'success',
            'message' => 'Image deleted successfully'
        ]);
    }

    public function changeImagePosition(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'position' => 'required',
        ]);
        $this->blogRepository->changeImagePosition($request->input('id'), $request->input('position'));
        return response()->json(['message' => 'Image position changed successfully']);
    }
}
