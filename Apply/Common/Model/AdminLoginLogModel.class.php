<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/26
 * Time: 23:35
 */

namespace Common\Model;


class AdminLoginLogModel extends CommonModel
{

    /**
     * 记录登录
     *
     * @param array $user_info
     * @return boolean
    */
    public function doLogin($user_info)
    {
        $arr_logData = $this->getLogData($user_info);
        if ($arr_logData) {
            return $this->add($arr_logData);
        }
        return false;
    }

    /**
     * 获得登录日志入表数组
     *
     * @param array $user_info
     * @return array
    */
    private function getLogData($user_info)
    {
        $arr_logData = [];

        $str_ip = get_client_ip();
        $arr_logData['login_ip'] = $str_ip;
        $arr_logData['login_time'] = time();
        $arr_logData['username'] = $user_info['username'];
        $arr_logData['uid'] = $user_info['id'];
        $arr_logData['authkey'] = $user_info['authkey'];

        return $arr_logData;
    }

}