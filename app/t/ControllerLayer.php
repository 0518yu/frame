<?php

namespace App\t;
/**
 * 记录方法的
 * 通过欺骗的方式将类的调用步骤记录下来
 * 最终通过函数方式激活
 * Class Layer
 * @package Core
 */
class ControllerLayer
{
    private $queue = [];
    private $con;
    private $args;

    function __construct($con, $args)
    {
        $this->con = $con;
        $this->args = $args;
    }

    // 依次调用储备的方法 / 直接调用某方法
    function __invoke($method = null)
    {
        $m = new $this->con(...$this->args);
        if (null === $method)
            foreach ($this->queue as $item) {
                $result = $m->{$item[0]}(...$item[1]);
                if (false === $result) return;
            }
        else
            return $m->{$method}();
    }

    function __call($func, $args)
    {
        $this->queue[] = [$func, $args];
        return $this;
    }
}