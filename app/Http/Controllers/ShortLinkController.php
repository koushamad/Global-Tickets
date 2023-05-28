<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortLinkRequest;
use App\Http\Requests\UpdateshortLinkRequest;
use App\Http\Resources\ShortLinkResource;
use App\Models\ShortLink;
use App\Service\Contract\ShortLinkServiceContract;
use App\Service\Contract\UserServiceContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ShortLinkController extends Controller
{
    public function __construct(
        private readonly UserServiceContract      $userService,
        private readonly ShortLinkServiceContract $shortLinkService
    )
    {
        $this->middleware(['auth:sanctum']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $user = $this->userService->getUserWithShotLinks(auth()->id());

        return ShortLinkResource::collection($user->shortLinks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShortLinkRequest $request): ShortLinkResource
    {
        $link = $this->shortLinkService->createShortLink(
            $request->get('url'),
            $request->user()
        );

        return ShortLinkResource::make($link);
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(ShortLink $shortLink): ShortLinkResource
    {
        $this->authorizeForUser(auth()->user(), 'view', $shortLink);

        return ShortLinkResource::make($shortLink);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdateshortLinkRequest $request, ShortLink $shortLink): ShortLinkResource
    {
        $this->authorizeForUser(auth()->user(), 'update', $shortLink);
        $shortLink = $this->shortLinkService->updateShortLink($request->get('url'), $shortLink);

        return ShortLinkResource::make($shortLink);
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(ShortLink $shortLink): Response
    {
        $this->authorizeForUser(auth()->user(), 'delete', $shortLink);
        $this->shortLinkService->deleteShortLint($shortLink);
        return response()->noContent();
    }
}
