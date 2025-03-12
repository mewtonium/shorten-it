<?php

namespace App\Actions;

use App\Models\Url;
use Lorisleiva\Actions\Concerns\AsAction;
use Vinkla\Hashids\Facades\Hashids;

class ShortenUrl
{
    use AsAction;

    public function handle(Url $url): string
    {
        $url->update([
            'hash' => Hashids::encode($url->id),
        ]);

        return route('url.visit', $url);
    }
}
