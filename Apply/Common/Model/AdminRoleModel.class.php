<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/26
 * Time: 23:37
 */

namespace Common\Model;


class AdminRoleModel extends CommonModel
{

    /**
     * 角色缓存键值
     *
     * @var string
    */
    protected $strCacheKey = 'AdminRoleCache';

    /**
     * 取得所有角色
     *
     * @return array
    */
    public function getRoleList()
    {
        $arr_role = S($this->strCacheKey);
        if (!$arr_role) {
            $arr_role = $this->updateCache();
        }
        return $arr_role;
    }

    /**
     * 更新角色缓存
     *
     * @return array
    */
    public function updateCache()
    {
        $arr_role = $this->select();
        $arr_role = array_column($arr_role, NULL, 'id');
        S($this->strCacheKey, $arr_role);
        return $arr_role;
    }

    /**
     * 删除角色
     *
     * @param int $int_roleId;
     * @return void|bool
    */
    public function romoveRole($int_roleId)
    {
        if (!$int_roleId) {
            return false;
        }
        $this->delete($int_roleId);
        $this->updateCache();
    }
}