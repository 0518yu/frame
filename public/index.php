<?php

// 入口时间
define("SYS_TIME", microtime(true));
define("PUBLIC_ROOT", __DIR__ . "/");

// 生命周期
require __DIR__ . "/../vendor/autoload.php";

// 静态文件直接返回
if ('/index.php' !== URI && is_file(PUBLIC_ROOT . URI)) return false;

// web uri
$router = require ROOT . "router.php";
isset($router[URI]) ? $router[URI]() : http_response_code(404);