<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/22
 * Time: 23:00
 */

namespace Home\Controller;


use Think\Controller;

class CommonController extends Controller
{
    /**
     * 控制器初始化
     *
     * @return void;
     */
    public function _initialize()
    {
        echo C('APP_SUB_DOMAIN_STATUS');
    }
}