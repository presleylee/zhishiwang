<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/27
 * Time: 22:52
 */

namespace Common\Model;


class AdminNodeModel extends CommonModel
{
    /**
     * 节点缓存名称
     *
     * @var string
    */
    protected $str_cache_name = 'node_list';

    /**
     * 获取所有开放节点
     *
     * @retrun array
    */
    public function getNodeList()
    {
        $arr_nodes = S($this->str_cache_name);
        if (empty($arr_nodes)) {
            $arr_nodes = $this->updateCache();
        }
        return $arr_nodes;
    }

    /**
     * 生存节点缓存
     *
     * @return array
    */
    public function updateCache()
    {
        $arr_map = [];
        $arr_map['status'] = 1;
        $arr_node = $this->where($arr_map)->select();
        if ($arr_node) {
            S($this->str_cache_name, $arr_node);
        }
        return $arr_node;
    }
}