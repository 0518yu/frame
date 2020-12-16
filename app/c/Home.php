<?php

namespace App\c;

use App\base\Controller;
use App\t\ControllerTrait;

class Home extends Controller
{
    use ControllerTrait;

    public function index()
    {
        $this->html() && include ROOT . "view/index.php";
    }
}