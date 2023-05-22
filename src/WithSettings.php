<?php

namespace Farzai\ModelSettings;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait WithSettings
{
    public function settings(): MorphMany
    {
        return $this->morphMany(config('model-settings.model'), 'model');
    }
}
