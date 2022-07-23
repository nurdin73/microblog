<?php

namespace App\Http\Controllers;

use App\Repositories\Holiday\HolidayRepository;
use Illuminate\Http\Request;

class HolidayControlller extends Controller
{
    protected $holidayRepository;
    public function __construct(HolidayRepository $holidayRepository)
    {
        $this->holidayRepository = $holidayRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startDate = $request->input('startDate') ?? '';
        $endDate = $request->input('endDate') ?? '';
        $limit = request()->query('limit', 10);
        $by = request()->query('by', 'created_at');
        $order = request()->query('order', 'desc');
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['limit'] = $limit;
        $data['holidays'] = $this->holidayRepository->paginate($startDate, $endDate, $limit, $by, $order);
        return view('admin.holiday.index', $data);
    }

    public function show($id)
    {
        return $this->holidayRepository->get($id);
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
            'start_date' => 'required|date',
            // 'status' => 'required|in:LIBUR,CUTI'
        ]);
        $data['end_date'] = $request->input('end_date');
        $this->holidayRepository->store($data);
        return redirect()->back()->with('success', "Holiday has been added");
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
            'start_date' => 'required|date',
            // 'status' => 'required|in:LIBUR,CUTI'
        ]);
        $data['end_date'] = $request->input('end_date');
        $this->holidayRepository->update($data, $id);
        return redirect()->back()->with('success', "Holiday has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->holidayRepository->destroy($id);
        return redirect()->back()->with('success', "Holiday has been deleted");
    }
}
