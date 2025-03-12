<?php

use App\Actions\ShortenUrl;
use App\Models\Url;
use Illuminate\Support\Str;

test('a url can be shortened', function () {
    $url = Url::factory()->create([
        'url' => 'https://www.google.co.uk',
    ]);

    $shortenedUrl = ShortenUrl::run($url);

    expect(Str::of($shortenedUrl)->isMatch('#^'.config('app.url').'\/[a-zA-Z0-9]{7}$#'))->toBeTrue();
});

test('a shortened url can be visited', function () {
    $url = Url::factory()->create([
        'url' => 'https://www.google.co.uk',
    ]);

    $response = $this->get(ShortenUrl::run($url));

    $response
        ->assertStatus(302)
        ->assertHeader('Location', 'https://www.google.co.uk');
});

test('a 404 is thrown if attempting to visit an invalid shortened url', function () {
    $response = $this->get(config('app.url').'/xxxxxxx');

    $response->assertStatus(404);
});
