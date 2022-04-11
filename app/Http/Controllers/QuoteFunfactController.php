<?php

namespace App\Http\Controllers;

use App\Repositories\QuoteFunfactRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuoteFunfactController extends Controller
{
    protected $quoteFunfactRepository;
    protected $tagRepository;
    public function __construct(QuoteFunfactRepository $quoteFunfactRepository,  TagRepository $tagRepository) {
        $this->quoteFunfactRepository = $quoteFunfactRepository;
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
        $data['quote_funfacts'] = $this->quoteFunfactRepository->all($search, $limit, $by, $order);
        return view('admin.quote-funfact.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['tags'] = $this->tagRepository->all();
        return view('admin.quote-funfact.create');
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
            'title' => 'required|max:255',
            'type' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|max:255',
            'published_at' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $data['slug'] = Str::slug($data['title']);
            $quote_funfact = $this->quoteFunfactRepository->add($data);
            if($request->has('tags')) {
                $tags = $request->input('tags');
                foreach($tags as $tag) {
                    $this->quoteFunfactRepository->syncTag($quote_funfact->id, $tag);
                }
            }
            DB::commit();
            return redirect()->route('admin.quote-funfacts.index')->with('success', 'Quote Funfact created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.quote-funfacts.index')->with('error', 'Quote Funfact creation failed.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->acceptsJson()) {
            $quote_funfact = $this->quoteFunfactRepository->get($id);
            return response()->json($quote_funfact);
        }
        $data['qf'] = $this->quoteFunfactRepository->get($id);
        return view('admin.quote-funfact.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['qf'] = $this->quoteFunfactRepository->get($id);
        return view('admin.quote-funfact.edit', $data);
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
            'title' => 'required|max:255',
            'type' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|max:255',
            'published_at' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $data['slug'] = Str::slug($data['title']);
            $quote_funfact = $this->quoteFunfactRepository->update($data, $id);
            if($request->has('tags')) {
                $tags = $request->input('tags');
                foreach($tags as $tag) {
                    $this->quoteFunfactRepository->syncTag($quote_funfact->id, $tag);
                }
            }
            DB::commit();
            return redirect()->route('admin.quote-funfacts.index')->with('success', 'Quote Funfact updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.quote-funfacts.index')->with('error', 'Quote Funfact update failed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.quote-funfacts.index')->with('error', 'Quote Funfact update failed.');
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
        $delete = $this->quoteFunfactRepository->delete($id);
        return redirect()->route('admin.quote-funfacts.index')->with('success', 'Quote Funfact deleted successfully');
    }
}
