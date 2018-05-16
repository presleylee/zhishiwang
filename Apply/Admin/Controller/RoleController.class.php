<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14
 * Time: 22:42
 */

namespace Admin\Controller;


class RoleController extends CommonController
{
    /**
     * 角色管理
    */
    public function index()
    {

        $arr_role = D('Common/AdminRole')->getRoleList();

        $this->assign('role', $arr_role);
        $this->display();
    }
}