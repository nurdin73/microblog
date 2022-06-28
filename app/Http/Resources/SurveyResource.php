<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
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
            'user_id' => $this->account_id,
            'weight' => "$this->weight kg",
            'height' => "$this->height cm",
            'result' => $this->result,
            'created_date' => $this->created_at->format('d F Y H:i:s'),
            'answers' => $this->whenLoaded('answers', function () {
                return $this->answers->map(function ($answer) {
                    return $answer->answer;
                });
            })
        ];
    }
}
