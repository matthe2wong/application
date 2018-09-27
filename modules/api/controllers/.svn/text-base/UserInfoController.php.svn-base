<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_UserInfoController extends Zend_Controller_Action
{
    private $modelUserInfo;
    
    public function init()
    {
        $this->modelUserInfo = new Application_Model_UserInfo();
        
        $this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {
        $this->_helper->layout()->disableLayout();
    }

    /**
     * 获取
     */
    public function getUserInfoByOpenidAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array(); 
        try {
            $openid = "1";
            $data = $this->modelUserInfo->getList(array("openid"=>$openid));
            if($data){
                $result = array('code' => 200, 'msg' => '获取成功','data' => $data);
            }else{
                $result = array('code' => 202, 'msg' => '暂无信息');
            }
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 在线签约
     */
    public function relatedCardAjaxAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        try {
//             $openid = Application_Model_WxUser::getWeixinOpenid();
            $openid = "1";
            $bind_type = $this->_request->getParam('bind_type');  // 绑定类型  卡号、身份证号、儿童
            $type = $this->_request->getParam('type');    //用户类型  本人or他人
            $card_no = $this->_request->getParam('card_no');    //就诊卡号
            $phone = $this->_request->getParam('phone');
            $identity_card = $this->_request->getParam('identity_card');
            $name = $this->_request->getParam('name');
            $birthday = $this->_request->getParam('birthday');
            $guardian = $this->_request->getParam('guardian');
            
            $data = array(
                "openid"         => $openid,
                "bind_type"      => $bind_type,
                "type"           => $type,
                "name"           => $name,
                "phone"          => $phone,
                "identity_card"  => $identity_card,
            );
            if($bind_type == 1){     //就诊卡签约
                $data["card_no"] = $card_no;
                $num = $this->modelUserInfo->getCount(array("openid"=>$openid,"card_no"=>$card_no));
//                 if($num > 0 )
//                     throw new Exception("您已添加该签约信息", 101);
            }else if($bind_type == 2){      //身份证号签约
                $num = $this->modelUserInfo->getCount(array("openid"=>$openid,"identity_card"=>$identity_card));
//                 if($num > 0 )
//                     throw new Exception("您已添加该签约信息", 102);
            }else{
                $data["birthday"] = $birthday;
                $data["guardian"] = $guardian;
            }
            $data["date"] = date('Y-m-d H:i:s',time());
            $newid = $this->modelUserInfo->insert($data);
            if($newid){
                $result = array('code' => 200, 'msg' => '添加成功','url' => "/wx/user-info/often");
            }else{
                $result = array('code' => 201, 'msg' => '添加失败');
            }
            
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    
}





