<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23
 * Time: 22:55
 */

namespace Admin\Controller;


use Think\Controller;

class CommonController extends Controller
{

    /**
     * @var 登录信息
    */
    public $userInfo = [];

    /**
     * 初始化函数
     *
     * @reture void;
    */
    public function _initialize()
    {

        //非指定域名访问跳转至404 页面
        $str_currentDomain = $_SERVER['HTTP_HOST'];
        $str_domain_prefix = reset( explode('.', $str_currentDomain) );
        if ($str_domain_prefix !== C('DOMAIN')['admin_prefix']) {
            jump404();
        }

        //验证登录情况
        $this->checkLogin();
    }

    /**
     * 验证登录情况
     *
     * @return void;
    */
    protected function checkLogin()
    {
        $this->userInfo = session( C('LOGIN_SESSION_KEY') );
        $arr_noValidController = C('NO_VALID_CONTROLLER');
        if ( empty($this->userInfo) && !in_array( strtolower(ACTION_NAME), $arr_noValidController[strtolower(CONTROLLER_NAME)] ) ) {
            $this->redirect('/Public/login');
        }
    }

    /**
     * 获取请求数据
     *
     * @param string $str_field;
     * @return mixed;
    */
    public function getData($str_field = '')
    {
        $str_method = IS_POST ? 'post.' : 'get.';
        return I($str_method . $str_field);
    }
}