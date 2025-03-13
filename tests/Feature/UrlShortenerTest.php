<?php

use App\Actions\ShortenUrl;
use App\Models\Url;
use Illuminate\Support\Str;

test('a url can be shortened', function () {
    $response = $this->post(route('url.shorten'), [
        'url' => 'https://www.google.co.uk',
    ]);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas(Url::class, [
        'url' => 'https://www.google.co.uk',
    ]);

    $shortenedUrl = ShortenUrl::run(Url::first());

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
    $response = $this->get(route('url.visit', ['hash' => 'XYZ1234']));

    $response->assertStatus(404);
});

test('the number of visits is incremented', function () {
    $url = Url::factory()
        ->unvisited()
        ->create([
            'url' => 'https://www.google.co.uk',
        ]);

    $this->get(ShortenUrl::run($url));

    $url->refresh();

    expect($url->visits)->toBe(1);
    expect($url->last_visited_at)->not->toBeNull();
});

test('a shortened url cannot be created if an invalid url is entered', function () {
    $response = $this->post(route('url.shorten'), [
        'url' => 'invalid-url',
    ]);

    $response->assertSessionHasErrors('url');

    $this->assertDatabaseMissing(Url::class, [
        'url' => 'invalid-url',
    ]);
});
