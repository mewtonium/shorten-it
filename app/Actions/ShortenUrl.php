<?php

namespace App\Actions;

use App\Models\Url;
use Lorisleiva\Actions\Concerns\AsAction;

class ShortenUrl
{
    use AsAction;

    public function handle(Url $url): string
    {
        return route('url.visit', ['hash' => $url->hash]);
    }
}
