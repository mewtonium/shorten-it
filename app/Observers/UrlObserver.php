<?php

namespace App\Observers;

use App\Models\Url;
use Vinkla\Hashids\Facades\Hashids;

class UrlObserver
{
    /**
     * Handle the `Url` model "created" event.
     */
    public function created(Url $url): void
    {
        $url->update([
            'hash' => Hashids::encode($url->id),
        ]);
    }
}
