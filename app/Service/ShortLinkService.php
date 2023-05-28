<?php

namespace App\Service;

use App\Jobs\ShortLinkClickedJob;
use App\Models\ShortLink;
use App\Models\User;
use App\Service\Contract\ShortLinkServiceContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class ShortLinkService implements ShortLinkServiceContract
{
    /**
     * Create a short link.
     */
    public function createShortLink(string $url, User $user): ShortLink
    {
        /** @var ShortLink $shortLink */
        $shortLink = $user->shortLinks()->create([
            'url' => $url,
            'user_id' => $user->id,
            'code' => $this->generateShortCode(),
        ]);

        Cache::put($this->getCacheKey($shortLink->code), $shortLink->url, now()->addDays(7));

        return $shortLink;
    }

    /**
     * Update Short link
     */
    public function updateShortLink(string $url, ShortLink $shortLink): ShortLink
    {
        $shortLink->url = $url;
        $shortLink->save();

        Cache::put($this->getCacheKey($shortLink->code), $shortLink->url, now()->addDays(7));

        return $shortLink;
    }

    /**
     * Delete Short Link
     */
    public function deleteShortLint(ShortLink $shortLink): void
    {

        Cache::forget($shortLink->code);

        $shortLink->delete();
    }

    /**
     * Get short link by code.
     *
     * @throws ModelNotFoundException<Model>
     */
    public function getShortLink(string $code): string
    {
        app()->terminating(function () use ($code) {
            ShortLinkClickedJob::dispatch($code);
        });

        return Cache::remember($this->getCacheKey($code), now()->addDays(7), function () use ($code) {
            /** @var ShortLink $sortLink */
            $sortLink = ShortLink::query()->where('code', $code)->firstOrFail();

            return $sortLink->url;
        });
    }

    /**
     * Increment clicks count.
     *
     * @throws ModelNotFoundException<Model>
     */
    public function incrementShortLinkClick(string $code): void
    {
        $shortLink = ShortLink::query()->where('code', $code)->firstOrFail();
        $shortLink->increment('clicks');
        $shortLink->save();
    }

    /**
     * Generate short code.
     */
    private function generateShortCode(): string
    {
        $shortCode = str()->random(6);

        if (ShortLink::query()->where('code', $shortCode)->first()) {
            return $this->generateShortCode();
        }

        return $shortCode;
    }

    /**
     * Get cache key.
     */
    private function getCacheKey(string $code): string
    {
        return "short_link_{$code}";
    }
}
