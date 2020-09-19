<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 2020-09-19
 * Time: 09:32.
 */

namespace app\area\controller;

use app\common\controller\AdminController;
use think\facade\View;

class Area extends AdminController
{
    function index()
    {
        return View::fetch('index');
    }
}