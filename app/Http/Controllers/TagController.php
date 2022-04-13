<?php

namespace App\Http\Controllers;

use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    protected $tagRepository;
    public function __construct(TagRepository $tagRepository) {
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
        $data['tags'] = $this->tagRepository->paginate($search, $limit, $by, $order);
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
        $store = $this->tagRepository->add($data);
        return redirect()->route('admin.master.tags.index')->with('success', 'Tag berhasil ditambahkan');
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
        return redirect()->route('admin.master.tags.index')->with('success', 'Tag berhasil diubah');
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
}
