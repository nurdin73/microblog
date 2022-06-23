<?php

namespace App\Http\Controllers;

use App\Http\Resources\HolidayResource;
use App\Repositories\Holiday\HolidayRepository;
use Illuminate\Http\Request;

class ApiHolidayController extends Controller
{
    protected $holidayRepository;
    public function __construct(HolidayRepository $holidayRepository)
    {
        $this->holidayRepository = $holidayRepository;
    }

    public function __invoke()
    {
        $limit = request()->limit;
        $result = $this->holidayRepository->all($limit);
        return response(['holiday' => HolidayResource::collection($result)]);
    }
}
