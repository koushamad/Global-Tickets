<?php

namespace App\Service;

use App\Models\ShortLink;
use App\Models\User;
use App\Service\Contract\ShortLinkServiceContract;

class ShortLinkService implements ShortLinkServiceContract
{
    /**
     * Create a short link.
     *
     * @param string $url
     * @param User $user
     *
     * @return ShortLink
     */
    public function createShortLink(string $url, User $user): ShortLink
    {
        /** @var ShortLink $shortLink */
        $shortLink = $user->shortLinks()->create([
            'url' => $url,
            'user_id' => $user->id,
            'code' => $this->generateShortCode(),
        ]);

        return $shortLink;
    }

    /**
     * Update Short link
     *
     * @param string $url
     * @param ShortLink $shortLink
     * @return ShortLink
     */
    public function updateShortLink(string $url, ShortLink $shortLink): ShortLink
    {
        $shortLink->url = $url;
        $shortLink->save();

        return $shortLink;
    }

    /**
     * Delete Short Link
     *
     * @param ShortLink $shortLink
     * @return void
     */
    public function deleteShortLint(ShortLink $shortLink): void {
        $shortLink->delete();
    }

    private function generateShortCode()
    {
        $shortCode = str()->random(6);

        if (ShortLink::query()->where('code', $shortCode)->first()) {
            return $this->generateShortCode();
        }

        return $shortCode;
    }
}
