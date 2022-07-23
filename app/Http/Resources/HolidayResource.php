<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HolidayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'title' => $this->title,
            'start_date' => Carbon::parse($this->start_date)->format('Y-m-d H:s'),
            'end_date' => $this->whenNotNull($this->end_date ? Carbon::parse($this->end_date)->format('Y-m-d H:s') : null),
            // 'status' => $this->status,
        ];
    }
}
