<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'account_id' => $this->account_id,
            'birthDate' => Carbon::parse($this->birthDate)->format('d F Y'),
            'age' => Carbon::parse($this->birthDate)->diffInYears(),
            'gender' => $this->gender,
            'latestSurvey' => $this->whenLoaded('latestSurvey', $this->latestSurvey->created_at->format('d F Y H:i:s')),
            'preferences' => $this->whenLoaded('preferences', function () {
                return $this->preferences->map(function ($preverence) {
                    return [
                        'id' => $preverence->id,
                        'name' => $preverence->name
                    ];
                });
            })
        ];
    }
}
