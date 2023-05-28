<?php

namespace App\Service\Contract;

use App\Models\ShortLink;
use App\Models\User;

interface ShortLinkServiceContract
{
    /**
     * Create a short link.
     *
     * @param string $url
     * @param User $user
     *
     * @return ShortLink
     */
    public function createShortLink(string $url, User $user): ShortLink;

    /**
     * Update Short link
     *
     * @param string $url
     * @param ShortLink $shortLink
     * @return ShortLink
     */
    public function updateShortLink(string $url, ShortLink $shortLink): ShortLink;

    /**
     * Delete Short Link
     *
     * @param ShortLink $shortLink
     * @return void
     */
    public function deleteShortLint(ShortLink $shortLink): void;
}
