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
     * 创建一棵菜单目录树
     *
     * @param array
     */
    public function buildMenuTree()
    {
        $arr_nodes = $this->getNodeList();

        $arr_tree = [];
        foreach ($arr_nodes as $id => $node) {
            if ($node['ismenu']) {
                $node['child'] = [];
                if ($node['pid']) {
                    $arr_firstParent = $arr_nodes[$node['pid']];
                    if ($arr_firstParent['pid']) {
                        $arr_secondParent = $arr_nodes[$arr_firstParent['pid']];
                        if (!$arr_secondParent['pid']) {
                            $arr_tree[$arr_secondParent['id']]['child'][$arr_firstParent['id']]['child'][$id] = $this->mergeNodes($arr_tree[$arr_secondParent['id']]['child'][$arr_firstParent['id']]['child'][$id], $node);
                        }
                    } else {
                        $arr_tree[$node['pid']]['child'][$id] = $this->mergeNodes($arr_tree[$node['pid']]['child'][$id], $node);
                    }
                } else {
                    $arr_tree[$id] = $this->mergeNodes($arr_tree[$id], $node);
                }
            } else {
                continue;
            }
        }
        return $arr_tree;
    }

    /**
     * 创建一棵节点目录树
     *
     * @param array
     */
    public function buildNodeTree()
    {
        $arr_nodes = $this->getNodeList();

        $arr_tree = [];
        foreach ($arr_nodes as $id => $node) {
            $node['child'] = [];
            if ($node['pid']) {
                $arr_firstParent = $arr_nodes[$node['pid']];
                if ($arr_firstParent['pid']) {
                    $arr_secondParent = $arr_nodes[$arr_firstParent['pid']];
                    if ($arr_secondParent['pid']) {
                        $arr_thirdParent = $arr_nodes[$arr_secondParent['pid']];
                        if (!$arr_thirdParent['pid']) {
                            $arr_tree[$arr_thirdParent['id']]['child'][$arr_secondParent['id']]['child'][$arr_firstParent['id']]['child'][$id] = $this->mergeNodes($arr_tree[$arr_thirdParent['id']]['child'][$arr_secondParent['id']]['child'][$arr_firstParent['id']]['child'][$id], $node);
                        }
                    } else {
                        $arr_tree[$arr_secondParent['id']]['child'][$arr_firstParent['id']]['child'][$id] = $this->mergeNodes($arr_tree[$arr_secondParent['id']]['child'][$arr_firstParent['id']]['child'][$id], $node);
                    }
                } else {
                    $arr_tree[$node['pid']]['child'][$id] = $this->mergeNodes($arr_tree[$node['pid']]['child'][$id], $node);
                }
            } else {
                $arr_tree[$id] = $this->mergeNodes($arr_tree[$id], $node);
            }
        }
        return $arr_tree;
    }

    /**
     * 合并已存在节点
     *
     * @param array $arr_tree
     * @param array $node ;
     * @return array
     */
    private function mergeNodes($arr_tree, $node)
    {
        if (isset($arr_tree)) {
            $arr_tree = array_merge($arr_tree, $node);
        } else {
            $arr_tree = $node;
        }
        return $arr_tree;
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
        $arr_node = array_column($arr_node, NULL, 'id');
        if ($arr_node) {
            S($this->str_cache_name, $arr_node);
        }
        return $arr_node;
    }
}