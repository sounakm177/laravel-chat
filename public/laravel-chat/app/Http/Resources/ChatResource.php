<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'participants' => UserResource::collection($this->participants),
            'last_message' => new MessageResource($this->lastMessage),
            'unread_count' => $this->unreadMessagesCount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}