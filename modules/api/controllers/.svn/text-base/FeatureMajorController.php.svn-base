<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_FeatureMajorController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelFeatureMajor;
    
    /**
     * 初始化
     */
    public function init()
    {
        $this->modelFeatureMajor = new Application_Model_FeatureMajor();
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
    }

    /**
     * 特色专业分页
     */
    public function newsListAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $result = array();
        try {
            $data = array();
            $page = $this->_request->getParam("page", 1);
            if ($page < 1) $page = 1;
            $pageCount = 8;
            $offset = ($page - 1) * $pageCount;
            $limit = array($offset, $pageCount);
    
            $tag = array();
            $data = $this->modelFeatureMajor->getList(null,array("date desc"),$limit);
            if (!$data){
                throw new Exception("暂无更多数据",300);
            }else{
                $data = $data->toArray();
                $result = array(
                    'code' => 200,
                    'msg' => '请求成功',
                    'data'=> $data
                );
            }
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * name:分页
     */
    public function newsListPageAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $result = array();
        try {
            $data = array();
            $page = $this->_request->getParam("page", 1);
            if ($page < 1) $page = 1;
            $pageCount = 8;
            $offset = ($page - 1) * $pageCount;
            $limit = array($offset, $pageCount);
    
            $tag = array();
            $data = $this->modelFeatureMajor->getList(null,array("date desc"),$limit);
            if (!$data){
                throw new Exception("暂无更多数据",300);
            }else{
                $data = $data->toArray();
                $result = array(
                    'code' => 200,
                    'msg' => '请求成功',
                    'data'=> $data
                );
            }
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
}













