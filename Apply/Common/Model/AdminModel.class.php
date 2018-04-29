<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/26
 * Time: 23:25
 */

namespace Common\Model;


class AdminModel extends CommonModel
{
    protected $tableName = 'admin';

    /**
     * 验证用户登录
     *
     * @param array $arr_postData
     * @return mixed;
    */
    public function checkLogin($arr_postData)
    {
        $arr_return = $arr_map = [];
        if (!$arr_postData)
            return ['type' => -1, 'msg' => '非法提交'];

        if (!is_array($arr_postData)) {
            return ['type' => -1, 'msg' => '数据格式不正确'];
        }

        $arr_map['username'] = $arr_postData['username'];
        $arr_userInfo = $this->where($arr_map)->find();
        if (empty($arr_userInfo)) {
            return ['type' => 1, 'msg' => '用户不存在'];
        }

        if ($arr_userInfo['is_lock']) {
            return ['type' => 2, 'msg' => '当前用户已被禁止登录'];
        }

        $str_password = $this->getPassword($arr_postData['password'], $arr_userInfo['verify']);
        if ( $str_password != $arr_userInfo['password'] ) {
            return ['type' => 3, 'msg' => '登录密码不正确'];
        }

        $arr_userInfo['authkey'] = md5($arr_map['username'].time());

        unset($arr_userInfo['verify'], $arr_userInfo['password']);
        return ['type' => 0, 'user_info' => $arr_userInfo];

    }

    /**
     * 登录后操作
     *
     * @param array $user_info;
     * @return array;
    */
    public function loginAfter($user_info)
    {
        $res = D('Common/AdminLoginLog')->doLogin($user_info);
        if ($res === false) {
            //写入错误日志，内容为 “记录authkey失败”
        }
        $arr_update = [];
        $arr_update['id'] = $user_info['id'];
        $arr_update['authkey'] = $user_info['authkey'];
        $this->save($arr_update);

    }

    /**
     * 生成登录密码
     *
     * @param string $str_password
     * @param string $str_verify
     * @return string
    */
    private function getPassword($str_password, $str_verify)
    {
        $str_originString = $str_password . C('PASSWORD_VERIFY');
        return md5( $str_originString . $str_verify );
    }
}