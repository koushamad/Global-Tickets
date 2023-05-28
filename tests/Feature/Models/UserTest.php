<?php

use App\Models\User;

it('should get user data', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson(route('api.user'));
    $response->assertOk();

    $response->assertJson([
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'short_links' => [],
        ],
    ]);
});
