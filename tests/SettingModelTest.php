<?php

use Farzai\ModelSettings\Facades\Setting;
use Farzai\ModelSettings\Tests\Models\Post;

beforeEach(function () {
    Setting::flush();
});

it('can set value', function () {
    $setting = Setting::for(Post::class);

    $setting->set('foo', 'bar');

    $this->assertDatabaseHas('model_settings', [
        'model_type' => (new Post)->getMorphClass(),
        'model_id' => null,
        'key' => 'foo',
        'value' => 'bar',
    ]);

    expect($setting->get('foo'))->toBe('bar');
});

it('can set value if model has id', function () {
    $post = Post::create([
        'title' => 'Hello World',
        'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
    ]);

    $setting = Setting::for($post);

    $setting->set('foo', 'bar');

    $this->assertDatabaseHas('model_settings', [
        'model_type' => (new Post)->getMorphClass(),
        'model_id' => $post->id,
        'key' => 'foo',
        'value' => 'bar',
    ]);

    expect($setting->get('foo'))->toBe('bar');
});
