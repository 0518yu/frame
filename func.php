<?php

define("ROOT", __DIR__ . "/");

function load_config($file = '.env')
{
    $file = ROOT . $file;
    if (!is_file($file)) return;
    $env = parse_ini_file($file, true);
    foreach ($env as $key => $val) {
        putenv("$key=$val");
        $_ENV[$key] = $val;
    }
}

load_config('.env');// 需要ROOT
// 获取 env 数据
function env($key, $default = '')
{
    $value = getenv($key);
    return false === $value ? $default : $value;
}

function hosts()
{
    return $_SERVER['HTTP_HOST'];
}

// 获取当前请求路由
function simple_uri()
{
    $uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : '';
    $uri = current(explode("?", $uri));
    $uri = strtolower($uri);// 不区分大小写
    // 优先router匹配
    $router = require ROOT . "router.php";
    if (in_array($uri, array_keys($router))) return $uri;

    // 伪静态: "/^\/([0-9a-zA-Z]+)\.html$/" "/^\/buy\-([0-9a-zA-Z]+)$/"
//    if (preg_match("/^\/buy\-([0-9a-zA-Z]+)$/", $uri, $arr)) {
//        $_GET['short_name'] = strtolower($arr[1]);
//        return '/buy_detail';
//    }
    return $uri;
}

function is_post()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function get_pass($str, $cost = 10)
{
    return password_hash($str, PASSWORD_BCRYPT, ["cost" => $cost]);
}

function check_pass($pass, $hash)
{
    return password_verify($pass, $hash);
}

// 防止用户输入的html 或者js代码执行
function _h($value)
{
    return htmlspecialchars($value, ENT_QUOTES);
}

function underscoreToCamelCase($string, $pascalCase = false)
{
    $string = strtolower($string);

    if ($pascalCase == true) {
        $string[0] = strtoupper($string[0]);
    }
    $func = function ($c) {
        return strtoupper($c[1]);
    };
    return preg_replace_callback("/_([a-z])/", $func, $string);
}

function rand_str($length, $lower = true)
{
    //字符组合
    $str = $lower ? 'abcdefghijklmnopqrstuvwxyz0123456789' : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $len = strlen($str) - 1;
    $randstr = '';
    for ($i = 0; $i < $length; $i++) {
        $num = mt_rand(0, $len);
        $randstr .= $str[$num];
    }
    return $randstr;
}

date_default_timezone_set('PRC');// 中国时区

// 解析uri 此处可以修改为自定义方法处理 伪静态 等
define("URI", simple_uri());


