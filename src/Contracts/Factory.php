<?php

namespace Farzai\ModelSettings\Contracts;

interface Factory
{
    /**
     * Create a new Setting instance from the given model.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     */
    public function for($model): Setting;
}
