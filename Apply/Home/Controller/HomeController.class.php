<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/22
 * Time: 22:59
 */

namespace Home\Controller;


class HomeController extends CommonController
{

    /**
     * 控制器初始化
    */
    /**
     * 控制器初始化
     *
     * @return void;
     */
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 网站首页
     *
     * @return void
    */
    public function index()
    {
        print_r( C('APP_SUB_DOMAIN_RULE'));
    }
}