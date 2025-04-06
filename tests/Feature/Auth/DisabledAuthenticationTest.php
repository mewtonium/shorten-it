<?php

use App\Models\User;

beforeEach(fn () => config(['auth.enabled' => false]));

test('login screen can\'t be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(404);
});

test('register screen can\'t be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
});

test('email verification screen can\'t be rendered', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(404);
});

test('confirm password screen can\'t be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/confirm-password');

    $response->assertStatus(404);
});

test('reset password link screen can\'t be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(404);
});
