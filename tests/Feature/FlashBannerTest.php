<?php

use Illuminate\Support\Facades\Session;

test('a flash message can be displayed', function () {
    Session::flash('banner.message', 'A test flash message!');

    $response = $this->get('/');

    $response
        ->assertSessionHas('banner.message', 'A test flash message!')
        ->assertSee('A test flash message!');
});
