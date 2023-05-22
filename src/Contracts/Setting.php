<?php

namespace Farzai\ModelSettings\Contracts;

use Illuminate\Support\Collection;

interface Setting
{
    /**
     * Get all settings.
     */
    public function all(): Collection;

    /**
     * Get the value of the given key.
     *
     * @param  mixed  $default
     */
    public function get(string $key, $default = null);

    /**
     * Set the value of the given key.
     */
    public function set(string $key, mixed $value);

    /**
     * Determine if the given key exists.
     */
    public function has(string $key): bool;

    /**
     * Remove the value of the given key.
     */
    public function forget(string $key);

    /**
     * Remove all settings.
     */
    public function flush();
}
