<?php


namespace App\t;


trait ControllerTrait
{
    /**
     * @param mixed ...$args
     * @return $this
     */
    public static function c(...$args)
    {
        return new ControllerLayer(self::class, $args);
    }
}