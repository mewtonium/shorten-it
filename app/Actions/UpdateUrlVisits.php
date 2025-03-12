<?php

namespace App\Actions;

use App\Models\Url;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUrlVisits
{
    use AsAction;

    public function handle(Url $url): void
    {
        $url->update([
            'visits' => ++$url->visits,
            'last_visited_at' => now(),
        ]);
    }
}
