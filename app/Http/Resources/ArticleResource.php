<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ArticleResource extends JsonResource
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
            'article_liked_id' => $this->article_liked_id,
            'title' => $this->title,
            'article_shopify_id' => $this->whenLoaded('articleLike', $this->articleLike->article_id),
            'image' => $this->image,
            'content' => Str::limit($this->content, 200),
            'created_at' => $this->created_at->format('d F Y'),
        ];
    }
}
