<?php

namespace App\Http\Controllers;

use App\Actions\UpdateUrlVisits;
use App\Models\Url;

class UrlController extends Controller
{
    /**
     * Redirects the shortened URL to the original URL.
     */
    public function visit(Url $url)
    {
        UpdateUrlVisits::run($url);

        return redirect()->to($url->url);
    }
}
