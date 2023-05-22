<?php

use Farzai\ModelSettings\Facades\Setting;

beforeEach(function () {
    Setting::flush();
});

it('can set value', function () {
    Setting::set('foo', 'bar');

    expect(Setting::get('foo'))->toBe('bar');

    $this->assertDatabaseHas('model_settings', [
        'key' => 'foo',
        'value' => 'bar',
        'model_id' => null,
        'model_type' => null,
    ]);
});

it('can set json value', function () {
    Setting::set('foo', ['bar' => 'baz']);

    expect(Setting::get('foo'))->toBe(['bar' => 'baz']);

    $this->assertDatabaseHas('model_settings', [
        'key' => 'foo',
        'value' => '{"bar":"baz"}',
        'model_id' => null,
        'model_type' => null,
    ]);
});

it('can set boolean value: true', function () {
    Setting::set('foo', true);

    expect(Setting::get('foo'))->toBe(true);

    $this->assertDatabaseHas('model_settings', [
        'key' => 'foo',
        'value' => 'true',
        'model_id' => null,
        'model_type' => null,
    ]);
});

it('can set boolean value: false', function () {
    Setting::set('foo', false);

    expect(Setting::get('foo'))->toBe(false);

    $this->assertDatabaseHas('model_settings', [
        'key' => 'foo',
        'value' => 'false',
        'model_id' => null,
        'model_type' => null,
    ]);
});

it('can remove value', function () {
    Setting::set('foo', 'bar');

    expect(Setting::get('foo'))->toBe('bar');

    Setting::forget('foo');

    expect(Setting::get('foo'))->toBeNull();

    $this->assertDatabaseMissing('model_settings', [
        'key' => 'foo',
        'value' => 'bar',
        'model_id' => null,
        'model_type' => null,
    ]);
});
