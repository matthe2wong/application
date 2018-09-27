<?php
/**
 * 数据表模型-用户数据
 * @author liujin
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Model_WxUser extends Application_Model_Base
{ 
    /**
     * 对应数据表名称
     */
    protected $_name = 'zf_wx_user';
    
    /**
     * 获得所有用户
     * @return 
     */
    public function getAllUsers()
    {
        return $this->getList();
    }
    
    /**
     * 根据openid获得用户对象
     * @param unknown $openid
     */
    public function getUserByOpenid($openid=null)
    {
        if ($openid == null) {
            $openid = Application_Model_WxUser::getWeixinOpenid();
        }
        $user = $this->getSingle(array('openid'=>$openid));
        if ($user == null) {
            $this->addUser($openid, '');
            $user = $this->getSingle(array('openid'=>$openid));
        } else {
            if ($user->nickname == null) {
                $this->updateUserInfoByOpenid($openid);
            }
        }
        return $user;
    }
    
    /**
     * 通过ID获得用户对象
     * @param int $userId
     */
    public function getUserById($userId)
    {
        return $this->getSingle(array('id'=>$userId));
    }
    
    /**
     * 获取会话变量值
     * @param string $key
     */
    public static function getSessionValue($key)
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $session = $storage->read();
        return isset($session[$key]) ? $session[$key] : null;
    }
    
    /**
     * 设置会话变量值
     * @param string $key 会话变量键
     * @param string $value 会话变量值
     */
    public static function setSessionValue($key, $value)
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $session[$key] = $value;
        $storage->write($session);
    }
    
    /**
     * 获得当前用户的id
     */
    public static function getCurrentUserId()
    {
        $userId = Application_Model_WxUser::getSessionValue('userId');
        if (!$userId) {
            $modelUser = new Application_Model_WxUser();
            $userId = $modelUser->getUserByOpenid()->id;
            Application_Model_WxUser::setSessionValue('userId', $userId);
        }
        return $userId;
    }
    
    /**
     * 获得用户的微信openid
     * @return string
     */
    public static function getWeixinOpenid()
    {
        $openid = Application_Model_WxUser::getSessionValue('openid');
        if (null == $openid) {  
            header('location:' . '/wx/sys-interface/get-openid/?request-uri='.urlencode($_SERVER['REQUEST_URI']));
            exit;
        }
        return $openid;
    }
    
    /**
     * 添加用户
     * @param string $openid
     * @param int $sceneId
     * @param string $sceneNote
     */
    public function addUser($openid, $sceneId=null, $sceneNote=null)
    {
        $user = $this->getSingle(array('openid'=>$openid));
        if ($user == null) {
            $newid = $this->insert(array(
                'openid' => $openid,
                'scene_id' => $sceneId == null ? '' : $sceneId,
                'scene_note' => $sceneNote == null ? '' : $sceneNote,
            ));
            $this->updateUserInfoByOpenid($openid);
            return $newid;
        } else {
            if ($user->nickname == null) {
                $this->updateUserInfoByOpenid($openid);
            }
        }
    }
    
    /**
     * 更新未获得微信数据的用户
     */
    public function fillUserInfoFromWeixin()
    {
        $userList = $this->getList("openid IS NOT NULL AND nickname IS NULL");
        foreach ($userList as $user) {
            $this->updateUserInfoByOpenid($user->openid);
        }
    }
    
    /**
     * 根据openid更新用户资料
     * @param string $openid
     */
    public function updateUserInfoByOpenid($openid)
    {
        $uri = sprintf('https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN',
            Szkj_Helper_WXBiz::getAccessToken(), $openid);
        $userInfo = json_decode(file_get_contents($uri));
        
        $sexMapping = array('0'=>'未知','1'=>'男','2'=>'女');
        $newid = $this->update(array(
            'create_time' => date('Y-m-d H:i:s'),
            'nickname' => $userInfo->nickname,
            'gender' => $sexMapping[$userInfo->sex],
            'city' => $userInfo->city,
            'country' => $userInfo->country,
            'province' => $userInfo->province,
            'language' => $userInfo->language,
            'weixin_avatar' => $userInfo->headimgurl,
            'weixin_remark' => $userInfo->remark,
            'weixin_groupid' => $userInfo->groupid,
        ), "openid='{$openid}'");
    }
    
    /**
     * 根据openid清空用户资料
     * @param string $openid
     */
    public function clearUserInfoByOpenid($openid)
    {
        $this->update(array(
            'nickname' => '',
            'gender' => '',
            'city' => '',
            'country' => '',
            'province' => '',
            'language' => '',
            'weixin_avatar' => '',
            'weixin_remark' => '',
            'weixin_groupid' => '',
        ), "openid='{$openid}'");
    }
    
    /**
     * 根据关键字查找用户
     * @param unknown $keyword
     */
    public function getUserList($keyword) {
        $sql = "SELECT * FROM {$this->_name} WHERE CONCAT(`nickname`) REGEXP REPLACE('$keyword',',','|')";
        return $this->rawQuery($sql);
    }
    
    
}

