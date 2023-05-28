<?php

use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

it('should show all user short links', function () {
    $shortLinksCount = 3;
    /** @var User $user */
    $user = User::factory()->hasShortLinks($shortLinksCount)->create();

    $response = $this->actingAs($user)->getJson(route('api.short-links.index'));
    $response->assertOk();
    $response->assertJsonCount($shortLinksCount, 'data');
    $response->assertJson(function (AssertableJson $json) use ($shortLinksCount, $user) {
        $json->count('data', $shortLinksCount);
        $json->has('data', $shortLinksCount, function (AssertableJson $json) use ($user) {
            $json->where('user_id', $user->id);
            $json->etc();
        });
        $json->etc();
    });
});

it('should create a short link', function () {
    /** @var User $user */
    /** @var ShortLink $shortLink */
    $user = User::factory()->create();
    $shortLink = ShortLink::factory()->make();

    $response = $this
        ->actingAs($user)
        ->postJson(route('api.short-links.store'), [
            'url' => $shortLink->url,
        ]);

    $response->assertSessionHasNoErrors();
    $response->assertJson(function (AssertableJson $json) use ($shortLink, $user) {
        $json->has('data', function (AssertableJson $json) use ($shortLink, $user) {
            $json->where('user_id', $user->id);
            $json->where('url', $shortLink->url);
            $json->etc();
        });
        $json->etc();
    });
    $this->assertDatabaseHas('short_links', [
        'user_id' => $user->id,
        'url' => $shortLink->url,
    ]);
});

it('should get a short link by id', function () {
    /** @var User $user */
    /** @var ShortLink $shortLink */
    $user = User::factory()->create();
    $shortLink = ShortLink::factory()->for($user)->create();

    $response = $this->actingAs($user)->getJson(route('api.short-links.show', $shortLink->id));

    $response->assertOk();
    $response->assertJson(function (AssertableJson $json) use ($shortLink, $user) {
        $json->has('data', function (AssertableJson $json) use ($shortLink, $user) {
            $json->where('id', $shortLink->id);
            $json->where('user_id', $user->id);
            $json->where('url', $shortLink->url);
            $json->where('code', $shortLink->code);
            $json->where('clicks', $shortLink->clicks);
            $json->where('short_link_url', $shortLink->short_link_url);
            $json->etc();
        });
        $json->etc();
    });
});

it('should return not found when user want to get a short link that not exists', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson(route('api.short-links.show', 1));

    $response->assertNotFound();
});

it('should return forbidden when user want to get another user short link', function () {
    /** @var User $user */
    /** @var User $anotherUser */
    /** @var ShortLink $shortLink */
    $user = User::factory()->create();
    $anotherUser = User::factory()->create();
    $shortLink = ShortLink::factory()->for($anotherUser)->create();

    $response = $this->actingAs($user)->getJson(route('api.short-links.show', $shortLink->id));

    $response->assertForbidden();
});

it('should delete a short link', function () {
    /** @var User $user */
    /** @var ShortLink $shortLink */
    $user = User::factory()->create();
    $shortLink = ShortLink::factory()->for($user)->create();

    $response = $this->actingAs($user)->deleteJson(route('api.short-links.destroy', $shortLink->id));

    $response->assertNoContent();
    $this->assertNotNull($shortLink->refresh()->deleted_at);
});

it('should return forbidden when user want to delete another user short link', function () {
    /** @var User $user */
    /** @var User $anotherUser */
    /** @var ShortLink $shortLink */
    $user = User::factory()->create();
    $anotherUser = User::factory()->create();
    $shortLink = ShortLink::factory()->for($anotherUser)->create();

    $response = $this->actingAs($user)->deleteJson(route('api.short-links.destroy', $shortLink->id));

    $response->assertForbidden();
});

it('should return not found when user want to delete a short link that not exists', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $response = $this->actingAs($user)->deleteJson(route('api.short-links.destroy', 1));

    $response->assertNotFound();
});

it('should update share link', function () {
    /** @var User $user */
    /** @var ShortLink $shortLink */
    $user = User::factory()->create();
    $shortLink = ShortLink::factory()->for($user)->create();

    $response = $this->actingAs($user)->putJson(route('api.short-links.update', $shortLink->id), [
        'url' => 'http://example.com',
    ]);

    $response->assertOk();
    $response->assertJson(function (AssertableJson $json) use ($shortLink, $user) {
        $json->has('data', function (AssertableJson $json) use ($shortLink, $user) {
            $json->where('id', $shortLink->id);
            $json->where('user_id', $user->id);
            $json->where('url', 'http://example.com');
            $json->where('code', $shortLink->code);
            $json->where('clicks', $shortLink->clicks);
            $json->where('short_link_url', $shortLink->short_link_url);
            $json->etc();
        });
        $json->etc();
    });
});

it('should return forbidden when user want to update another user short link', function () {
    /** @var User $user */
    /** @var User $anotherUser */
    /** @var ShortLink $shortLink */
    $user = User::factory()->create();
    $anotherUser = User::factory()->create();
    $shortLink = ShortLink::factory()->for($anotherUser)->create();

    $response = $this->actingAs($user)->putJson(route('api.short-links.update', $shortLink->id), [
        'url' => 'http://example.com',
    ]);

    $response->assertForbidden();
});

it('should return not found when user want to update a short link that not exists', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $response = $this->actingAs($user)->putJson(route('api.short-links.update', 1), [
        'url' => 'http://example.com',
    ]);

    $response->assertNotFound();
});

it('should forward user to the original url', function () {
    /** @var User $user */
    /** @var ShortLink $shortLink */
    $user = User::factory()->create();
    $shortLink = ShortLink::factory()->for($user)->create();

    $response = $this->get($shortLink->short_link_url);

    $response->assertRedirect($shortLink->url);
});

it('should increase clicks when user visit the short link', function () {
    /** @var User $user */
    /** @var ShortLink $shortLink */
    $user = User::factory()->create();
    $shortLink = ShortLink::factory()->for($user)->create();

    $this->get($shortLink->short_link_url);

    $this->assertEquals($shortLink->clicks + 1, $shortLink->refresh()->clicks);
});
