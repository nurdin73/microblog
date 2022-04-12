<?php

namespace App\Http\Controllers;

use App\Repositories\CollectionRepository;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    protected $collectionRepository;

    public function __construct(CollectionRepository $collectionRepository) {
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['collections'] = $this->collectionRepository->all();
        return view('admin.collection.index', $data);
    }

    public function collections()
    {
        return $this->collectionRepository->all(true);
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
            'collection_id' => 'required|max:255',
            'title' => 'required|max:255',
            'caption' => 'required'
        ]);

        $add = $this->collectionRepository->add($data);
        return redirect()->route('admin.collection.index')->with('success', 'Collection added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->collectionRepository->get($id);
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
            'collection_id' => 'required|max:255',
            'title' => 'required|max:255',
            'caption' => 'required'
        ]);

        $update = $this->collectionRepository->update($id, $data);
        return redirect()->route('admin.collection.index')->with('success', 'Collection updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->collectionRepository->delete($id);
        return redirect()->back()->with('success', 'Collection deleted successfully');
    }
}
