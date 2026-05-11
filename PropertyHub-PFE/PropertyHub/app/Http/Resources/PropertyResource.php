<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? 'Property',
            'description' => $this->description,
            'price' => $this->price,
            'location' => $this->location,
            'bedrooms' => $this->bedrooms ?? 0,
            'bathrooms' => $this->bathrooms ?? 0,
            'area' => $this->area ?? 0,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'agent' => new UserResource($this->whenLoaded('agent')),
            'galleries' => GalleryResource::collection($this->whenLoaded('galleries')),
            'thumbnail' => $this->galleries->first()?->image_url ?? null,
        ];
    }
}
