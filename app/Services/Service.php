<?php


namespace App\Services;


abstract class Service
{
    protected function findMessage($key, $item = null)
    {
        return trans(trans('messages.' . $key, ['item' => __($item)]));
    }
}
