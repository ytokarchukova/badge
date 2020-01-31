<?php

namespace YTokarchukova\Badge\Facades;

use Illuminate\Support\Facades\Facade;

class Badge extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'badge';
    }
}
