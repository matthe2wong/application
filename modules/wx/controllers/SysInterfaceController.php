<?php
/**
 * 微信消息接口交互处理
 * @abstract 包括微信中的事件处理、消息处理等
 * @author liujin
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_SysInterfaceController extends Zend_Controller_Action
{
    public function init()
    {
        
    }
    
    /**
     * 微信事件及消息接口
     */
    public function indexAction()
    {
        include_once APPLICATION_PATH."/../library/wxmsgcrypt/wxBizMsgCrypt.php";
        
        /**
         * 微信接口有效性验证
         */
        $echostr = $this->_request->getParam('echostr');
        if ($echostr) {
            echo $echostr;
            exit;
        }
        /**
         * 微信事件及消息处理
         */
        else if (Szkj_Helper_WXBiz::checkSignature(WX_TOKEN)) {
            
            $pc = new WXBizMsgCrypt(WX_TOKEN, WX_ENCODING_AES_KEY, WX_APPID);
            $signature = $_GET["msg_signature"];
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];
            $encryptXml = $GLOBALS["HTTP_RAW_POST_DATA"];
            $msgXml = '';
            $errCode = $pc->decryptMsg($signature, $timestamp, $nonce, $encryptXml, $msgXml);
            
            $postObj = simplexml_load_string($msgXml, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = (string)($postObj->FromUserName);
            $toUsername = (string)($postObj->ToUserName);
            $msgType = $postObj->MsgType;
            $keyword = trim($postObj->Content);
            $event = $postObj->Event;
            $eventKey = $postObj->EventKey;
            
            $reply = '';
            
            // 添加微信用户信息至数据库
            $modelWxUser = new Application_Model_WxUser();
            $modelWxUser->addUser($fromUsername);
            
            /**
             * case1: 自定义菜单事件
             */
            if (!empty($eventKey)) {
                $reply = $this->handleEvent($event, $eventKey, $fromUsername, $toUsername);
            }
            
            /**
             * case2: 用户发送消息
             */
            if(!empty( $keyword )) {
                $reply = $this->handleKeyword($keyword, $fromUsername, $toUsername);
            }
            
            if (trim($reply) != '')
                echo Szkj_Helper_WXMsg::textMsg(
                    $fromUsername,
                    $toUsername,
                    $reply);
            exit;
        }
        exit;
    }
    
    /**
     * 处理关键词
     * @param string $keyword
     * @param string $fromUsername
     * @param string $toUsername
     */
    private function handleKeyword($keyword, $fromUsername, $toUsername)
    {
        $reply = "您好，欢迎关注！";
        
        /**
         * [关键词规则1]
         */
        if ($keyword == '') {
            $reply = '';
        } 
        /**
         * [关键词规则2]
         */
        else if ($keyword == '') {
            $reply = '';
        }
        
        return $reply;
    }
    
    /**
     * 处理事件
     * @param string $eventKey
     * @param string $fromUsername
     * @param string $toUsername
     * @return string
     */
    private function handleEvent($event, $eventKey, $fromUsername, $toUsername)
    {
        $reply = "";
        
        /**
         * 关注回复
         */
        if ($event == 'subscribe') {
            $reply = "您好，欢迎关注！";
            // 添加微信用户信息至数据库
            $modelWxUser = new Application_Model_WxUser();
            $modelWxUser->addUser($fromUsername);
        }
        
        /**
         * [事件标识1]
         */
        if ($eventKey == 'V1001_TEST') {
            $reply = "点击测试";
        }
        /**
         * [事件标识2]
         */
        else if ($eventKey == "V1002_USER_BOUND") {
            $reply = "";
        }
        
        return $reply;
    }
    
    /**
     * 获得Openid
     */
    public function getOpenidAction()
    {
        $code = $this->_request->getParam('code');
        $state = $this->_request->getParam('state');
    
        if ($code) {
            $uri = sprintf(
                "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code",
                WX_APPID, WX_APPSECRET, $code);
            $response = Zend_Json::decode(file_get_contents($uri));
            $openid = @$response['openid'];
    
            /**
             * 存入Session
            */
            $auth = Zend_Auth::getInstance();
            $storage = $auth->getStorage();
            $userData['openid'] = $openid;
            $storage->write($userData);
    
            /**
             * 跳转回请求网页
            */
            $requestUri = $state;
            $this->_redirect(urldecode($requestUri));
        } else {
            $appid = WX_APPID;
            $redirectUri = urlencode('http://'.$_SERVER['HTTP_HOST'].'/wx/sys-interface/get-openid');
            $scope = 'snsapi_base';
            $state = $this->_request->getParam('request-uri');
    
            $uri = sprintf(
                "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=%s#wechat_redirect",
                $appid, $redirectUri, $scope, $state);
            $this->_redirect($uri);
        }
    }
    
}