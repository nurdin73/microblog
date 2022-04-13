<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{

    protected $userKey;
    public $resource;

    public function __construct($resource, $userKey = '') {
        $this->userKey = $userKey;
        $this->resource = $resource;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $data['id'] = $this->resource->id;
        $data['title'] = $this->resource->title;
        $data['slug'] = $this->resource->slug;
        $data['content'] = $this->resource->content;
        $data['posted_at'] = $this->resource->created_at->format('d F Y');
        $data['total_like'] = $this->when(isset($this->likes_count), $this->likes_count);
        $data['liked'] = $this->whenLoaded('likes', function() {
            if($this->likes) {
                return true;
            }
            return false;
        }) ?? false;
        $data['tags'] = $this->whenLoaded('tags', function () {
            return TagResource::collection($this->tags);
        });
        $data['photos'] = $this->whenLoaded('photos', function () {
            return BlogPhotoResource::collection($this->photos);
        });
        return $data;
    }
}
