<?php
/**
 * 微信模块引导文件
 * @abstract 微信模块引导文件，此处进行微信相关的常量定义
 * @author liujin
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_Bootstrap extends Zend_Application_Module_Bootstrap
{
    /**
     * 控制器前置工作
     */
    protected function _initController()
    {
        defined('WX_APPID')
        || define('WX_APPID', 'wxce900651028f90ec');
        
        defined('WX_APPSECRET')
        || define('WX_APPSECRET', 'cecc9b8c2a72c2c269f967279b74d9ba');
        
        defined('WX_TOKEN')
        || define('WX_TOKEN', 'test');
        
        defined('WX_ENCODING_AES_KEY')
        || define('WX_ENCODING_AES_KEY', 'bCwhqDh6FsYA7Dn1ADkmMkAXJA2DK13wOoYuDhubZrN');
    }
}