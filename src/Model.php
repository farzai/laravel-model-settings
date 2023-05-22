<?php

namespace Farzai\ModelSettings;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    protected $table = 'model_settings';

    protected $fillable = [
        'key',
        'value',
        'model_id',
        'model_type',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
