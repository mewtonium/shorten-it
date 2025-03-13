<?php

namespace App\Http\Controllers;

use App\Actions\ShortenUrl;
use App\Actions\UpdateUrlVisits;
use App\Http\Requests\StoreUrlRequest;
use App\Models\Url;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Vinkla\Hashids\Facades\Hashids;

class UrlController extends Controller
{
    /**
     * [untitled function]
     */
    public function shorten(StoreUrlRequest $request)
    {
        $url = Url::query()->firstOrCreate([
            'url' => $request->url,
        ]);

        return back()->with('url', [
            'shortened' => ShortenUrl::run($url),
            'original' => $url->url,
            'visits' => $url->visits,
            'lastVisitedAt' => $url->last_visited_at?->format('d/m/Y @ g:ia'),
        ]);
    }

    /**
     * Redirects the shortened URL to the original URL.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function visit(string $hash): RedirectResponse
    {
        if (($id = Hashids::decode($hash)[0] ?? 0) === 0) {
            abort(404);
        }

        try {
            $url = Url::query()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        UpdateUrlVisits::run($url);

        return redirect()->away($url->url);
    }
}
