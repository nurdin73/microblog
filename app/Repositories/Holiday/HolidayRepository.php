<?php

namespace App\Repositories\Holiday;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayRepository implements HolidayInterface
{
    protected $holidays;
    public function __construct(Holiday $holiday)
    {
        $this->holidays = $holiday;
    }

    public function paginate(String $startDate = '', String $endDate, Int $limit = 10, String $by = 'created_at', String $order = 'desc')
    {
        $results = $this->holidays->select('*');
        if ($startDate != '') {
            $startDate = "$startDate 00:00:00";
            $results = $results->where('start_date', '>=', $startDate);
        }

        if ($endDate != '') {
            $endDate = "$endDate 00:00:00";
            $results = $results->where('end_date', '<=', $endDate);
        }

        $results = $results->orderBy($by, $order)->paginate($limit);
        return $results;
    }

    public function store(array $data)
    {
        return $this->holidays->updateOrCreate($data);
    }

    public function update(array $data, Int $id)
    {
        $check = $this->get($id);
        return $check->update($data);
    }

    public function destroy(Int $id)
    {
        $check = $this->get($id);
        return $check->delete();
    }

    public function get($id)
    {
        return $this->holidays->findOrFail($id);
    }

    public function all($limit = null)
    {
        if ($limit) {
            return $this->holidays->take($limit)->get();
        }
        return $this->holidays->get();
    }
}
