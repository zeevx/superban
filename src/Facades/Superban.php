<?php

namespace Zeevx\Superban\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Zeevx\Superban\Superban
 */
class Superban extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Zeevx\Superban\Superban::class;
    }
}
