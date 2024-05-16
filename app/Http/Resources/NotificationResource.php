<?php

namespace App\Http\Resources;

use App\Http\Traits\Notificatable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\formatDate;

class NotificationResource extends JsonResource
{
    use Notificatable;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'message'   => $this->message,
            'item'    => $this->getNotificationItemResource($this->notificatable_type, $this->notificatable_id),
            'published_at' => formatDate($this->created_at),
            'is_read' => $this->users->find(Auth::user()->id)->pivot->is_read
        ];
    }
}
