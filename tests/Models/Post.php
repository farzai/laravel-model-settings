<?php

namespace Farzai\ModelSettings\Tests\Models;

use Farzai\ModelSettings\WithSettings;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use WithSettings;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'body',
    ];
}
