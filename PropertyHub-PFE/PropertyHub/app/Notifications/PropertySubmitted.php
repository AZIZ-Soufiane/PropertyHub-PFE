<?php

namespace App\Notifications;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PropertySubmitted extends Notification
{
    use Queueable;

    public function __construct(public Property $property)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'property_id' => $this->property->id,
            'title' => $this->property->title,
            'agent_name' => $this->property->agent?->name ?? 'Unknown Agent',
            'message' => "New property '{$this->property->title}' was submitted by " . ($this->property->agent?->name ?? 'an agent') . " and is pending review.",
            'type' => 'property_submitted',
        ];
    }
}
