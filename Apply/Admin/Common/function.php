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
 * @param integer $totalRows
 * @param integer $int_pagesize
 * @param string $parameter
 * @return string
*/
function showAdmin($totalRows, $limitRow, $parameter)
{
    $page = new \Common\Extend\Page($totalRows, $limitRow, $parameter);
    $page->rollPage = 10;
    $page->lastSuffix = false;
    $page->setConfig('first', '首页');
    $page->setConfig('prev', '上一页');
    $page->setConfig('next', '下一页');
    $page->setConfig('last', '最后一页');
    return $page->show();
}
