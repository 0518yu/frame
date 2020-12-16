<?php


namespace App\base;


class Controller
{
    protected $module = '';
    protected $is_api = false;
    protected $content_type = [
        'js' => "Content-type: application/javascript; charset=utf-8",
        'html' => "Content-Type: text/html; charset=utf-8",
        'json' => "Content-type: application/json; charset=utf-8"
    ];

    // 调试用
    final protected function debug_info($info)
    {
        exit("<pre>" . print_r($info, true) . "<pre>");
    }

    /**
     * 接口项目 is_api默认为true vue-axios 需要合并raw中的数据
     * ControllerBase constructor.
     * @param bool $is_api
     * @param bool $merge_raw
     */
    final public function __construct($is_api = true, $merge_raw = true)
    {
        $this->is_api = $is_api;

        if ($merge_raw) {
            $params = json_decode(file_get_contents("php://input"), 1);
            if (is_array($params)) $_POST = array_merge($_POST, $params);
        }
    }

    /**
     * api接口返回json
     * @param $arr
     * @return bool
     */
    final protected function resp($arr)
    {
        header($this->content_type['json']);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        return true;
    }

    // 重定向
    final protected function redirect($url, $isDebug = false)
    {
        if ($isDebug) exit("<a href=\"{$url}\">{$url}</a>");
        echo <<<STR
<script type="text/javascript">window.location.href="{$url}"</script>
STR;
        return true;
    }

    // 直接输出html页面
    final protected function html()
    {
        $seconds_to_cache = 72 * 3600;
        $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
        header("Expires: $ts");
        header("Pragma: cache");
        header("Cache-Control: max-age=$seconds_to_cache");
        header($this->content_type['html']);
        return true;
    }

    // 带有过期时间的静态文件
    final protected function js($arr)
    {
        $seconds_to_cache = 72 * 3600;
        $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
        header("Expires: $ts");
        header("Pragma: cache");
        header("Cache-Control: max-age=$seconds_to_cache");
        header($this->content_type['js']);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        return true;
    }

    final public function get_module()
    {
        return $this->module;
    }
}