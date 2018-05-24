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
     *
     * @return void
     */
    public function index()
    {

        $arr_role = D('Common/AdminRole')->getRoleList();
        $arr_ids = array_column($arr_role, 'id');
        if ($arr_ids) {
            $arr_map = [];
            $arr_map['role_id'] = ['in', $arr_ids];
            $arr_stat = D('Common/Admin')->where($arr_map)->field("count(*) as total, role_id")->group('role_id')->select();
            $arr_stat = array_column($arr_stat, NULL, 'role_id');
            foreach ($arr_role as &$item) {
                $item['members'] = $item[$item['id']]['total'] ?: 0;
            }

        }

        $this->assign('role', $arr_role);
        $this->display();
    }

    /**
     * 添加角色
     *
     * @return void
     */
    public function add()
    {
        if (IS_POST) {
            $arr_data = $this->getPostData();
            $res = D('Common/AdminRole')->add($arr_data);
            if ($res) {
                D('Common/AdminRole')->updateCache();
                message('添加成功', 1);
            } else {
                message('添加失败', 3);
            }
        }
        $this->display();
    }

    /**
     * 编辑角色
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->getData('id');
        if (!$id) {
            message('参数不正确', 3);
        }

        $info = D("Common/AdminRole")->find($id);
        if (empty($info)) {
            message('你要修改角色不存', 3);
        }

        if (IS_POST) {
            $arr_Data = $this->getPostData(true);
            $res = D('Common/AdminRole')->where(['id' => $info['id']])->save($arr_Data);
            if ($res !== false) {
                D('Common/AdminRole')->updateCache();
                message('修改成功', 1, '/Role/index');
            } else {
                message('修改失败', 3);
            }
        }

        $this->assign('info', $info);
        $this->display();
    }

    /**
     * 删聊角色
     *
     * @return void
    */
    public function delete()
    {
        $id = $this->getData('id');
        if (!$id) {
            message('非法操作', 3);
        }

        D('Common/AdminRole')->romoveRole($id);
        message('操作成功', 1);
    }

    /**
     * 获取请求数据
     *
     * @param bool $bool_IsEdit
     * @return array
     */
    private function getPostData($bool_IsEdit = false)
    {
        $arr_Post = $this->getData();

        $arr_Data = [];
        $arr_Data['pid'] = (int)$arr_Post['pid'];
        if (!$arr_Post['name']) {
            message('必须填写角色名称', 3);
        }
        $arr_Data['name'] = $arr_Post['name'];
        $arr_Data['describe'] = (string)$arr_Post['describe'];

        $arr_map = [];
        $arr_map['name'] = $arr_Data['name'];
        if ($bool_IsEdit) {
            $id = $this->getData('id');
            $arr_map['id'] = ['neq', $id];
        }
        if (D('Common/AdminRole')->where($arr_map)->count() > 0) {
            message('当前节点已存在', 3);
        }
        $arr_Data['status'] = (int)$arr_Post['status'];

        return $arr_Data;
    }
}