<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Common\Extend;

class Page extends \Think\Page
{

    public $firstRow; // 起始行数
    public $listRows; // 列表每页显示行数
    public $parameter; // 分页跳转时要带的参数
    public $totalRows; // 总行数
    public $totalPages; // 分页总页面数
    public $rollPage = 11; // 分页栏每页显示的页数
    public $lastSuffix = true; // 最后一页是否显示总页数
    private $p = 'p'; //分页参数名
    private $url = ''; //当前链接URL
    private $nowPage = 1;
    // 分页显示定制
    private $config = array(
        'header' => '<span class="rows">共 %TOTAL_ROW% 条记录</span>',
        'prev' => '<<',
        'next' => '>>',
        'first' => '1...',
        'last' => '...%TOTAL_PAGE%',
        'theme' => '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
    );

    /**
     * 架构函数
     * @param array $totalRows 总的记录数
     * @param array $listRows 每页显示记录数
     * @param array $parameter 分页跳转的参数
     */
    public function __construct($totalRows, $listRows = 20, $parameter = array())
    {
        C('VAR_PAGE') && $this->p = C('VAR_PAGE'); //设置分页参数名称
        /* 基础设置 */
        $this->totalRows = $totalRows; //设置总记录数
        $this->listRows = $listRows;  //设置每页显示行数
        $this->parameter = empty($parameter) ? $_GET : $parameter;
        $this->nowPage = empty($_GET[$this->p]) ? 1 : intval($_GET[$this->p]);
        $this->nowPage = $this->nowPage > 0 ? $this->nowPage : 1;
        $this->firstRow = $this->listRows * ($this->nowPage - 1);
    }

    /**
     * 定制分页链接设置
     * @param string $name 设置名称
     * @param string $value 设置值
     */
    public function setConfig($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * 生成链接URL
     * @param  integer $page 页码
     * @return string
     */
    private function url($page)
    {
        return str_replace(urlencode('[PAGE]'), $page, $this->url);
    }

    function getUri()
    {
        $request_uri = __SELF__;
        $url = strstr($request_uri, '?') ? $request_uri : $request_uri . '?';
        $info = parse_url($request_uri);
        if (isset($info['query'])) {
            $query = $info['query'];
            if (is_array($query)) {
                $url .= http_build_query($query);
            } elseif ($query != '') {
                $url .= '&' . trim($query, '?&');
            }
        }
        $arr = parse_url($url);
        if (isset($arr['query'])) {
            parse_str($arr['query'], $arrs);
            unset($arrs['p']);
            $url = $arr['path'] . '?' . http_build_query($arrs);
        }

        if (strstr($url, '?')) {
            if (substr($url, -1) != '?') {
                $url = $url . '&';
            }
        } else {
            $url .= '?';
        }
        return $url;
    }

    /**
     * 组装分页链接
     * @return string
     */
    public function show()
    {
        if (0 == $this->totalRows)
            return '';

        /* 生成URL */
        $this->parameter[$this->p] = '[PAGE]';
        $this->url = U(ACTION_NAME, $this->parameter);
        /* 计算分页信息 */
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
        if (!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }

        /* 计算分页零时变量 */
        $now_cool_page = $this->rollPage / 2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<li><a href="' . $this->getUri() . 'p=' . $up_row . '"><i class="entypo-left-open-mini"></i>' . $this->config['prev'] . '</a></li>' : '';

        //下一页
        $down_row = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<li><a href="' . $this->getUri() . 'p=' . $down_row . '"><i class="entypo-right-open-mini"></i>' . $this->config['next'] . '</a></li>' : '';

        //第一页
        $the_first = '';
        if ($this->totalPages > $this->rollPage && ($this->nowPage - $now_cool_page) >= 1) {
            $the_first = '<li><a href="' . $this->getUri(1) . 'p=1">' . $this->config['first'] . '</a></li>';
        }

        //最后一页
        $the_end = '';
        if ($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages) {
            $the_end = '<li><a href="' . $this->getUri() . 'p=' . $this->totalPages . '">' . $this->config['last'] . '</a></li>';
        }

        //数字连接
        $link_page = "";
        for ($i = 1; $i <= $this->rollPage; $i++) {
            if (($this->nowPage - $now_cool_page) <= 0) {
                $page = $i;
            } elseif (($this->nowPage + $now_cool_page - 1) >= $this->totalPages) {
                $page = $this->totalPages - $this->rollPage + $i;
            } else {
                $page = $this->nowPage - $now_cool_page_ceil + $i;
            }
            if ($page > 0 && $page != $this->nowPage) {

                if ($page <= $this->totalPages) {
                    $link_page .= '<li><a href="' . $this->getUri() . 'p=' . $page . '">' . $page . '</a><li>';
                } else {
                    break;
                }
            } else {
                if ($page > 0 && $this->totalPages != 1) {
                    $link_page .= '<li class="active"><a href="javascript:;">' . $page . '</a></li>';
                }
            }
        }

        //替换分页内容
        $page_str = str_replace(
            array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'), array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages), $this->config['theme']);
        return "{$page_str}";
    }

    public function showMobilePage()
    {
        if (0 == $this->totalRows)
            return '';

        /* 生成URL */
        $this->parameter[$this->p] = '[PAGE]';
        $this->url = U(ACTION_NAME, $this->parameter);
        /* 计算分页信息 */
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
        if (!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }

        /* 计算分页零时变量 */
        $now_cool_page = $this->rollPage / 2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<a  href="' . $this->getUri() . 'p=' . $up_row . '">' . $this->config['prev'] . '</a>' : '';

        //下一页
        $down_row = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<a href="' . $this->getUri() . 'p=' . $down_row . '">' . $this->config['next'] . '</a>' : '';

        //第一页
        $the_first = '';
        if ($this->totalPages > $this->rollPage && ($this->nowPage - $now_cool_page) >= 1) {
            $the_first = '<a href="' . $this->getUri(1) . 'p=1">' . $this->config['first'] . '</a>';
        }

        //最后一页
        $the_end = '';
        if ($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages) {
            $the_end = '<a class="end" href="' . $this->getUri() . 'p=' . $this->totalPages . '">' . $this->config['last'] . '</a>';
        }

        //数字连接
        $link_page = "<label for='pageCounts' name='pageDown'><select id='pageCounts' class='needsclick'>";
        for ($i = 1; $i <= ceil($this->totalRows / $this->listRows); $i++) {
            if ($this->nowPage == $i) {
                $link_page .= "<option selected='selected' value='" . $this->getUri() . 'p=' . $i . "'" . ">$i/$this->totalPages</option>";
            } else {
                $link_page .= "<option value='" . $this->getUri() . 'p=' . $i . "'" . ">$i/$this->totalPages</option>";
            }
        }
        $link_page .= "</select></label>";
        //替换分页内容
        $page_str = str_replace(
            array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'), array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages), '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
        return "<div class='page'>{$page_str}</div>";
    }

    public function showPage()
    {
        if (0 == $this->totalRows)
            return '';

        /* 生成URL */
        $this->parameter[$this->p] = '[PAGE]';
        $this->url = U(ACTION_NAME, $this->parameter);
        /* 计算分页信息 */
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
        if (!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }

        /* 计算分页零时变量 */
        $now_cool_page = $this->rollPage / 2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<a href="' . $this->getUri() . 'p=' . $up_row . '">' . $this->config['prev'] . '</a>' : '';

        //下一页
        $down_row = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<a href="' . $this->getUri() . 'p=' . $down_row . '">' . $this->config['next'] . '</a>' : '';

        //第一页
        $the_first = '';
        if ($this->totalPages > $this->rollPage && ($this->nowPage - $now_cool_page) >= 1) {
            $the_first = '<a href="' . $this->getUri(1) . 'p=1">' . $this->config['first'] . '</a>';
        }

        //最后一页
        $the_end = '';
        if ($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages) {
            $the_end = '<a href="' . $this->getUri() . 'p=' . $this->totalPages . '">' . $this->config['last'] . '</a>';
        }

        //数字连接
        $link_page = "";
        for ($i = 1; $i <= $this->rollPage; $i++) {
            if (($this->nowPage - $now_cool_page) <= 0) {
                $page = $i;
            } elseif (($this->nowPage + $now_cool_page - 1) >= $this->totalPages) {
                $page = $this->totalPages - $this->rollPage + $i;
            } else {
                $page = $this->nowPage - $now_cool_page_ceil + $i;
            }
            if ($page > 0 && $page != $this->nowPage) {

                if ($page <= $this->totalPages) {
                    $link_page .= '<a href="' . $this->getUri() . 'p=' . $page . '">' . $page . '</a>';
                } else {
                    break;
                }
            } else {
                if ($page > 0 && $this->totalPages != 1) {
                    $link_page .= '<span>' . $page . '</span>';
                }
            }
        }

        //替换分页内容
        $page_str = str_replace(
            array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'), array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages), $this->config['theme']);
        return "{$page_str}";
    }

    public function showUserPage()
    {
        if (0 == $this->totalRows)
            return '';

        /* 生成URL */
        $this->parameter[$this->p] = '[PAGE]';
        $this->url = U(ACTION_NAME, $this->parameter);
        /* 计算分页信息 */
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
        if (!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }

        /* 计算分页零时变量 */
        $now_cool_page = $this->rollPage / 2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row = $this->nowPage - 1;
        $up_page ='';
        if ($up_row) {
            if ($up_row == 1) {
                $up_page = '<a href="' . trim($this->getUri(), '?') . '" class="next">' . $this->config['prev'] . '</a>';
            } else {
                $up_page = '<a href="' . $this->getUri() . 'p=' . $up_row . '" class="next">' . $this->config['prev'] . '</a>';
            }
        }
        //$up_page = $up_row > 0 ? '<a href="' . $this->getUri() . 'p=' . $up_row . '/" class="next">' . $this->config['prev'] . '</a>' : '';

        //下一页
        $down_row = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<a href="' . $this->getUri() . 'p=' . $down_row . '" class="next">' . $this->config['next'] . '</a>' : '';

        //第一页
        $the_first = '';
        if ($this->totalPages > $this->rollPage && ($this->nowPage - $now_cool_page) >= 1) {
            //$the_first = '<a href="' . $this->getUri(1) . 'p=1/">' . $this->config['first'] . '</a>';
            //去掉首页?p=1
            $the_first = '<a href="' . trim($this->getUri(1), '?') . '">' . $this->config['first'] . '</a>';
        }

        //最后一页
        $the_end = '';
        if ($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages) {
            $the_end = '<a href="' . $this->getUri() . 'p=' . $this->totalPages . '">' . $this->config['last'] . '</a>';
        }

        //数字连接
        $link_page = "";
        for ($i = 1; $i <= $this->rollPage; $i++) {
            if (($this->nowPage - $now_cool_page) <= 0) {
                $page = $i;
            } elseif (($this->nowPage + $now_cool_page - 1) >= $this->totalPages) {
                $page = $this->totalPages - $this->rollPage + $i;
            } else {
                $page = $this->nowPage - $now_cool_page_ceil + $i;
            }
            if ($page > 0 && $page != $this->nowPage) {
                if ($page <= $this->totalPages) {
                    //隐藏p=1的入口
                    if ($page == 1) {
                        $link_page .= '<a href="' . trim($this->getUri(), '?') . '">' . $page . '</a>';
                    } else {
                        $link_page .= '<a href="' . $this->getUri() . 'p=' . $page . '">' . $page . '</a>';
                    }
                } else {
                    break;
                }
            } else {
                if ($page > 0 && $this->totalPages != 1) {
                    $link_page .= '<strong class="current">' . $page . '</strong>';
                }
            }
        }

        //替换分页内容
        $page_str = str_replace(
            array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'), array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages), $this->config['theme']);
        return "{$page_str}";
    }
}
