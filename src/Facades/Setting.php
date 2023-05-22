<?php

namespace Farzai\ModelSettings\Facades;

use Farzai\ModelSettings\Contracts\Setting as SettingContract;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Farzai\AppSettings\Setting
 */
class Setting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SettingContract::class;
    }
}
