<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/29
 * Time: 19:23
 */

/**
 * 生成管理员 verify
 *
 * @return string
*/
function getVerify()
{
    return substr(uniqid(), 6);
}

/**
 * 显示错误信息
 *
 * @return void
*/
function message($msg = '', $code = null, $url = '')
{
    switch ($code) {
        case 1:
            Session('message_success', $msg);
            cookie('submit', 0);
            break;
        case 2:
            session('message_info', $msg);
            break;
        case 3:
            session('message_warning', $msg);
            break;
        case 4:
            session('message_error', $msg);
            break;
        default:
            session('msg', 'You are make a mistake');
    }

    $url = $url?:$_SERVER['HTTP_REFERER'];

    header('HTTP/1.1 302 Moved Permanently');
    header('location:' . $url);

    die();
}

/**
 * 生成分页条
 *
 * @param integer $int_total
 * @param integer $int_pagesize
 * @return string
*/
function showAdmin($int_total, $int_pagesize)
{
    $res_page = new \Think\Page($int_total, $int_pagesize);
    return $res_page->show();//  分页显示输出
}
