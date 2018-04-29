<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/29
 * Time: 19:23
 */

/**
 * 生成管理员 verify
*/
function getVerify()
{
    return substr(uniqid(), 6);
}