<?php

namespace App\Http\Resources;

use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ShortLink
 */
class ShortLinkResource extends JsonResource
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
            'code' => $this->code,
            'url' => $this->url,
            'user_id' => $this->user_id,
            'clicks' => $this->clicks,
            'short_link_url' => $this->short_link_url,
            'user' => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
        ];
    }
}
