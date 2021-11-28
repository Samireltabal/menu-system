<?php

namespace SamirEltabal\MenuSystem;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VendorName\Skeleton\Skeleton
 */
class MenuSystemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'menusystem';
    }

    public static function ping() {
        return response()
        ->json(
            ['message' => 'syncit Menu is responding', 'version' => config('menu.version')],
        201);
    }
}