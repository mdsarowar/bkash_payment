<?php

namespace Sarowar\Bkash\Facades;

use Illuminate\Support\Facades\Facade;

class Bkash extends Facade
{
    /**
     * @method static array token()
     * @method static \Illuminate\Http\RedirectResponse create_payment()
     * @method static object exicutepay($data)
     * @method static object querypayment($data)
     */
    protected static function getFacadeAccessor()
    {
        return 'bkash';
    }
}
