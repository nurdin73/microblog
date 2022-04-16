<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Repositories\Collection\CollectionRepository;
use App\Traits\Shopify;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    use Shopify;
    protected $collectionRepository;

    public function __construct(CollectionRepository $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
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
        $data['collections'] = $this->collectionRepository->paginate($search, $limit, $by, $order);
        $data['search'] = $search;
        $data['limit'] = $limit;
        $data['shopify_collections'] = $this->getAllCollections();
        return view('admin.collection.index', $data);
    }

    public function collections()
    {
        $limit = request()->query('limit', '');
        $search = request()->query('search', '');
        $data = $this->collectionRepository->all(true, $search, $limit);
        return response(CollectionResource::collection($data), 200);
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

        try {
            $add = $this->collectionRepository->add($data);
            return redirect()->route('admin.collections.index')->with('success', 'Collection added successfully');
        } catch (\Exception $e) {
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
        return $this->collectionRepository->get($id);
    }

    public function edit($id)
    {
        $data['shopify_collections'] = $this->getAllCollections();
        $data['collection'] = $this->collectionRepository->get($id);
        return view('admin.collection.edit', $data);
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

        try {
            $update = $this->collectionRepository->update($id, $data);
            return redirect()->route('admin.collections.index')->with('success', 'Collection updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Collection update failed');
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
        $delete = $this->collectionRepository->delete($id);
        return redirect()->back()->with('success', 'Collection deleted successfully');
    }
}
