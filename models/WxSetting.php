<?php
/**
 * 微信号配置信息数据表模型
 * @author liujin
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Model_WxSetting extends Application_Model_Base
{
    protected $_name = 'zf_wx_setting';
    
    /**
     * 获得某条配置
     * @param string $key
     * @return string
     */
    public function readSetting($key)
    {
        $value = null;
        $single = $this->getSingle("`key`='$key'");
        if ($single != null && $single->expire_time > time()) {
            $value = $single->value;
        }
        
        return $value;
    }
    
    /**
     * 写入某条配置
     * @param string $key
     * @param string $value
     */
    public function writeSetting($key, $value) {
        $single = $this->getSingle("`key`='$key'");
        if ($single) {
            $this->updateData($single->id, array(
                'value' => $value,
                'expire_time' => time() + 7200,
            ));
        } else {
            $this->insert(array(
                'key' => $key,
                'value' => $value,
                'expire_time' => time() + 7200,
            ));
        }
    }
    
    /**
     * 获得微信的access_token
     * @return string
     */
    public function getWeixinAccessToken()
    {
        $key = 'weixin_access_token';
        $value = $this->readSetting($key);
        return $value;
    }
    
    /**
     * 存入微信的access_token
     * @param string $value
     */
    public function setWeixinAccessToken($value)
    {
        $key = 'weixin_access_token';
        $this->writeSetting($key, $value);
    }
    
    /**
     * 获得微信的jsapi_ticket
     * @return string
     */
    public function getJsapiTicket()
    {
        $key = 'weixin_jsapi_ticket';
        return $this->readSetting($key);
    }
    
    /**
     * 存入微信的jsapi_ticket
     * @param string $value
     */
    public function setJsapiTicket($value)
    {
        $key = 'weixin_jsapi_ticket';
        $this->writeSetting($key, $value);
    }
    
    /**
     * 获得微信企业号的qiye_access_token
     * @return string
     */
    public function getWeixinQiyeAccessToken()
    {
        $key = 'weixin_qiye_access_token';
        return $this->readSetting($key);
    }
    
    /**
     * 设置微信企业号的qiye_access_token
     * @param string $value
     */
    public function setWeixinQiyeAccessToken($value)
    {
        $key = 'weixin_qiye_access_token';
        $this->writeSetting($key, $value);
    }
    
    
}