<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\Collection\CollectionRepository;
use App\Repositories\Holiday\HolidayRepository;
use App\Repositories\QuoteFunfact\QuoteFunfactRepository;
use App\Traits\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Helper;
    protected $blogRepository;
    protected $collectionRepository;
    protected $quoteFunfactRepository;
    protected $holidayRepository;
    public function __construct(BlogRepository $blogRepository, CollectionRepository $collectionRepository, QuoteFunfactRepository $quoteFunfactRepository, HolidayRepository $holidayRepository)
    {
        $this->blogRepository = $blogRepository;
        $this->collectionRepository = $collectionRepository;
        $this->quoteFunfactRepository = $quoteFunfactRepository;
        $this->holidayRepository = $holidayRepository;
    }
    public function __invoke()
    {
        $data['blog_total'] = $this->blogRepository->total();
        $data['blogLinkTotal'] = $this->quoteFunfactRepository->total('all');
        $data['collection_total'] = $this->collectionRepository->total();
        $data['api_token'] = $this->getToken();
        $holidays = $this->holidayRepository->all()->map(function ($item) {
            $row = [
                'id' => $item->id,
                'title' => $item->title,
                'start' => Carbon::parse($item->start_date)->format('Y-m-d'),
            ];
            if ($item->end_date) {
                $row['end'] = Carbon::parse($item->end_date)->format('Y-m-d');
            }
            $row['classNames'] = $item->status == 'LIBUR' ? ['bg-red-700'] : ['bg-yellow-700'];
            $row['backgroundColor'] = $item->status == 'LIBUR' ? '#c81e1e' : '#8e4b10';
            $row['borderColor'] = $item->status == 'LIBUR' ? '#c81e1e' : '#8e4b10';
            $row['textColor'] = '#fff';
            return $row;
        });
        $data['holidays'] = $holidays;
        return view('admin.index', $data);
    }
}
