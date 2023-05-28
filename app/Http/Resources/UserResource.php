<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $request->user()->email,
            'short_links' => $this->whenLoaded('shortLinks', function () {
                return ShortLinkResource::collection($this->shortLinks);
            }),
            'token' => $request->user() ? $request->user()->createToken('auth_token')->plainTextToken : null,

        ];
    }
}
