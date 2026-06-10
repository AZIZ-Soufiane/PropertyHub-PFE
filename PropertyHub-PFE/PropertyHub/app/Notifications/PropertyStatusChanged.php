<?php

namespace App\Notifications;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PropertyStatusChanged extends Notification
{
    use Queueable;

    public function __construct(public Property $property, public string $status, public ?string $note = null)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $message = "Your property listing '{$this->property->title}' has been {$this->status}.";
        if ($this->note) {
            $message .= " Admin Note: {$this->note}";
        }

        return [
            'property_id' => $this->property->id,
            'title' => $this->property->title,
            'status' => $this->status,
            'note' => $this->note,
            'message' => $message,
            'type' => 'property_status_changed',
        ];
    }
}
