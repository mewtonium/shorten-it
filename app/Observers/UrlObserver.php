<?php

namespace App\Observers;

use App\Actions\ShortenUrl;
use App\Models\Url;

class UrlObserver
{
    /**
     * Handle the `Url` model "created" event.
     */
    public function created(Url $url): void
    {
        ShortenUrl::run($url);
    }
}
