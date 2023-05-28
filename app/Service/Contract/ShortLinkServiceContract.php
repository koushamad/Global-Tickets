<?php

namespace App\Service\Contract;

use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ShortLinkServiceContract
{
    /**
     * Create a short link.
     */
    public function createShortLink(string $url, User $user): ShortLink;

    /**
     * Update Short link
     */
    public function updateShortLink(string $url, ShortLink $shortLink): ShortLink;

    /**
     * Delete Short Link
     */
    public function deleteShortLint(ShortLink $shortLink): void;

    /**
     * Get short link by code.
     *
     * @throws ModelNotFoundException<Model>
     */
    public function getShortLink(string $code): string;

    /**
     * Increment clicks count.
     *
     * @throws ModelNotFoundException<Model>
     */
    public function incrementShortLinkClick(string $code): void;
}
