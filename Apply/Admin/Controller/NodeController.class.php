<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 21:24
 */

namespace Admin\Controller;


class NodeController extends CommonController
{
    /**
     * 系统首页
     *
     * @return void
    */
    public function index()
    {

        $arr_nodes = D('Common/AdminNode')->buildNodeTree();
        $this->assign('node', $arr_nodes);
        $this->display();
    }

    /**
     * 添加节点
     *
     * @return void
    */
    public function add()
    {
        if (IS_POST) {
            $arr_Data = $this->getPostData();
            $res = D('Common/AdminNode')->add($arr_Data);
            if ($res) {
                D('Common/AdminNode')->updateCache();
                message('添加成功', 1);
            } else {
                message('添加失败', 3);
            }
        }
        $arr_nodes = D('Common/AdminNode')->buildNodeTree();
        $this->assign('node', $arr_nodes);
        $this->display();
    }

    /**
     * 修改节点
     *
     * @return void;
     */
    public function edit()
    {
        $id = $this->getData('id');
        if (!$id) {
            message('参数不正确', 3);
        }

        $info = D("Common/AdminNode")->find($id);
        if (empty($info)) {
            message('你要修改节点不存', 3);
        }

        if (IS_POST) {
            $arr_Data = $this->getPostData(true);
            $res = D('Common/AdminNode')->where(['id' => $info['id']])->save($arr_Data);
            if ($res !== false) {
                D('Common/AdminNode')->updateCache();
                message('修改成功', 1, '/Node/index');
            } else {
                message('修改失败', 3);
            }
        }

        $this->assign('info', $info);
        $arr_nodes = D('Common/AdminNode')->buildNodeTree($info['id']);
        $this->assign('node', $arr_nodes);
        $this->display();
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
            message('必须填写节点名称', 3);
        }
        $arr_Data['name'] = $arr_Post['name'];

        if (!$arr_Post['controller']) {
            message('必须填写控制器名称', 3);
        }
        $arr_Data['controller'] = $arr_Post['controller'];

        if (!$arr_Post['action']) {
            message('必须填写方法名称', 3);
        }
        $arr_Data['action'] = $arr_Post['action'];

        $arr_map = [];
        $arr_map['name'] = $arr_Data['name'];
        $arr_map['controller'] = $arr_Data['controller'];
        $arr_map['action'] = $arr_Post['action'];
        if ($bool_IsEdit) {
            $id = $this->getData('id');
            $arr_map['id'] = ['neq', $id];
        }
        if (D('Common/AdminNode')->where($arr_map)->count() > 0) {
            message('当前节点已存在', 3);
        }

        $arr_Data['isMenu'] = (int)$arr_Post['isMenu'];
        $arr_Data['status'] = (int)$arr_Post['status'];

        return $arr_Data;
    }
}