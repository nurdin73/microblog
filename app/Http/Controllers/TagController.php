<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Repositories\Tag\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    protected $tagRepository;
    public function __construct(TagRepository $tagRepository)
    {
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
        $by = request()->query('by', 'updated_at');
        $order = request()->query('order', 'desc');
        $data['tags'] = $this->tagRepository->paginate($search, $limit, $by, $order);
        $data['search'] = $search;
        $data['limit'] = $limit;
        return view('admin.master.tags', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $check = $this->tagRepository->find('name', $data['name']);
        if ($check) {
            return redirect()->back()->with('error', 'Tag already exists');
        }
        $store = $this->tagRepository->add($data);
        return redirect()->route('admin.master.tags.index')->with('success', 'Create tags successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->tagRepository->detail($id);
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
        $data = $request->validate([
            'name' => 'required|max:255',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $update = $this->tagRepository->update($id, $data);
        return redirect()->route('admin.master.tags.index')->with('success', "Tag Update successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->tagRepository->delete($id);
        return redirect()->route('admin.master.tags.index')->with('success', 'Tag berhasil dihapus');
    }

    public function tags()
    {
        $search = request()->search ?? '';
        $all = $this->tagRepository->all($search);
        return TagResource::collection($all);
    }
}
