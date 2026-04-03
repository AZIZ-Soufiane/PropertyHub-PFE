<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'date_time' => $this->date_time,
            'status' => $this->status,
            'buyer' => new UserResource($this->whenLoaded('buyer')),
            'agent' => new UserResource($this->whenLoaded('agent')),
            'property_id' => $this->property_id ?? null,
            'created_at' => $this->created_at,
        ];
    }
}
