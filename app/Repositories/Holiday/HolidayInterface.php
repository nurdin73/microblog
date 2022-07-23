<?php

namespace App\Repositories\Holiday;

interface HolidayInterface
{
    public function paginate(String $startDate = '', String $endDate, Int $limit = 10, String $by = 'created_at', String $order = 'desc');

    public function store(array $array);

    public function update(array $array, Int $id);

    public function destroy(Int $id);

    public function all($limit = null);
}
