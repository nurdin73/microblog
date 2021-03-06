<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuoteFunfactCollection;
use App\Http\Resources\QuoteResource;
use App\Repositories\QuoteFunfact\QuoteFunfactRepository;
use App\Repositories\Tag\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuoteFunfactController extends Controller
{
    protected $quoteFunfactRepository;
    protected $tagRepository;
    public function __construct(QuoteFunfactRepository $quoteFunfactRepository,  TagRepository $tagRepository)
    {
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
        $data['search'] = $search;
        $data['limit'] = $limit;
        return view('admin.quote-funfact.index', $data);
    }

    public function getRandomQuotesFunfacts()
    {
        $limit = request()->query('limit', '');
        $data = $this->quoteFunfactRepository->random($limit);
        if ($data->count() == 0) return response(['message' => 'Blog link not found'], 404);
        return response(QuoteResource::collection($data), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['tags'] = $this->tagRepository->all();
        return view('admin.quote-funfact.create', $data);
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
            'content' => 'required',
            'status' => 'required|in:published,draft',
            'published_at' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $data['link'] = $request->input('link');
            $data['slug'] = Str::slug($data['title']);
            $quote_funfact = $this->quoteFunfactRepository->add($data);
            if ($request->has('tags')) {
                $tags = $request->input('tags');
                foreach ($tags as $tag) {
                    $this->quoteFunfactRepository->syncTag($quote_funfact->id, $tag);
                }
            }
            DB::commit();
            return redirect()->route('admin.quote-funfacts.index')->with('success', 'Blog link created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.quote-funfacts.index')->with('error', 'Blog link creation failed.');
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
        $data['tags'] = $this->tagRepository->all();
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
            'content' => 'required',
            'status' => 'required|max:255',
            'published_at' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $data['link'] = $request->input('link');
            $data['slug'] = Str::slug($data['title']);
            $quote_funfact = $this->quoteFunfactRepository->update($data, $id);
            if ($request->has('tags')) {
                $tags = $request->input('tags');
                foreach ($tags as $tag) {
                    $this->quoteFunfactRepository->syncTag($quote_funfact->id, $tag);
                }
            }
            DB::commit();
            return redirect()->route('admin.quote-funfacts.index')->with('success', 'Blog link updated successfully.');
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
        $delete = $this->quoteFunfactRepository->delete($id);
        return redirect()->route('admin.quote-funfacts.index')->with('success', 'Blog link deleted successfully');
    }
}
