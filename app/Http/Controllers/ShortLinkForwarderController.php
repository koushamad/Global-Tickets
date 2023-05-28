<?php

namespace App\Http\Controllers;

use App\Service\Contract\ShortLinkServiceContract;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ShortLinkForwarderController extends Controller
{
    public function __construct(
        private readonly ShortLinkServiceContract $shortLinkService
    ) {
        $this->middleware(['guest']);
    }

    public function __invoke(string $code): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        return redirect($this->shortLinkService->getShortLink($code));
    }
}
