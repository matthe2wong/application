<?php
/**
 * 微信自定义菜单
 * @abstract 微信自定义菜单的创建、获取
 * @author liujin
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_SysMenuController extends Zend_Controller_Action
{
    private $modelWxMenu;
    
    public function init()
    {
        $this->modelWxMenu = new Application_Model_WxMenu();
    }
    
    /**
     * 获取菜单信息
     */
    public function getMenuAction()
    {
        $uri = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=" . Szkj_Helper_WXBiz::getAccessToken();
        $response = file_get_contents($uri);
        echo $response;
        exit;
    }
    
    /**
     * 自定义菜单创建
     */
    public function createMenuAction()
    {
        $uri = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . Szkj_Helper_WXBiz::getAccessToken();
        
        $rootMenus = $this->modelWxMenu->getList('status=1 AND parent_id=0', 'order_no ASC');
        $buttons = array();
        foreach ($rootMenus as $rm) {
            $button = array('name'=>$rm->name);
            $subMenus = $this->modelWxMenu->getList("status=1 AND parent_id='{$rm->id}'", 'order_no ASC');
            if ($subMenus) {
                $subButtons = array();
                foreach ($subMenus as $sm) {
                    $subButton = array();
                    $subButton['type'] = $sm->type;
                    $subButton['name'] = $sm->name;
                    if ($subButton['type'] == 'view') $subButton['url'] = $sm->url;
                    if ($subButton['type'] == 'click') $subButton['key'] = $sm->key;
                    if ($subButton['type'] == 'scancode_push') $subButton['key'] = $sm->key;
                    array_push($subButtons, $subButton);
                }
                $button['sub_button'] = $subButtons;
            } else {
                $button['type'] = $rm->type;
                if ($button['type'] == 'view') $button['url'] = $rm->url;
                if ($button['type'] == 'click') $button['key'] = $rm->key;
                if ($button['type'] == 'scancode_push') $button['key'] = $rm->key;
            }
            array_push($buttons, $button);            
        }
        $menuData = array('button'=>$buttons);
        $data = $this->json_encode_ex($menuData);
        
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $uri );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        
        print_r($return);
        exit;
    }
    
    public function json_encode_ex($value)
    {
        if (version_compare(PHP_VERSION,'5.4.0','<'))
        {
            $str = json_encode($value);
            $str = preg_replace_callback(
                "#\\\u([0-9a-f]{4})#i",
                function($matchs)
                {
                    return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
                },
                $str
            );
            return $str;
        }
        else
        {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }
    }
}