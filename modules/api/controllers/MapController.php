<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_MapController extends Zend_Controller_Action
{
    private $modelMap;
    public function init()
    {
        $this->modelMap = new Application_Model_Map();
    }

    public function indexAction()
    {
        $this->_helper->layout()->disableLayout();
    }

    /**
     * 获取医院坐标
     */
    public function mapAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        try {
            $data = $this->modelMap->getSingle(array("id"=>1));
            $data = $data->toArray();
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
    
        echo Zend_Json::encode($result);
    }
    
}





