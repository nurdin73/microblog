<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\Collection\CollectionRepository;
use App\Repositories\QuoteFunfact\QuoteFunfactRepository;
use App\Traits\Helper;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Helper;
    protected $blogRepository;
    protected $collectionRepository;
    protected $quoteFunfactRepository;
    public function __construct(BlogRepository $blogRepository, CollectionRepository $collectionRepository, QuoteFunfactRepository $quoteFunfactRepository)
    {
        $this->blogRepository = $blogRepository;
        $this->collectionRepository = $collectionRepository;
        $this->quoteFunfactRepository = $quoteFunfactRepository;
    }
    public function __invoke()
    {
        $data['blog_total'] = $this->blogRepository->total();
        $data['blogLinkTotal'] = $this->quoteFunfactRepository->total('all');
        $data['collection_total'] = $this->collectionRepository->total();
        $data['api_token'] = ApiToken::where('user_id', auth()->id())->first()->sort_token;
        return view('admin.index', $data);
    }
}
