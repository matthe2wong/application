<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_NewsController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelNews;
    private $modelAbouts;
    /**
     * 初始化
     */
    public function init()
    {
        $this->modelNews = new Application_Model_News();
        $this->modelAbouts = new Application_Model_Abouts();
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
    }

    /**
     * 就诊指南
     */
    public function attendanceGuideAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        try {
            $type = $this->_request->getParam('data_type');
            if($type == 1){
                $data = $this->modelNews->getSingle(array("type"=>2));
            }else{
                $data = $this->modelAbouts->getSingle(array("id"=>1));
            }
            if(!$data){
                throw new Exception("无数据", 101);
            }
            $data = $data->toArray();
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        
        echo Zend_Json::encode($result);
    }
    
    /**
     * 分页
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
            $type = $this->_request->getParam("type");
            if ($page < 1) $page = 1;
            $pageCount = 8;
            $offset = ($page - 1) * $pageCount;
            $limit = array($offset, $pageCount);
    
            $tag = array();
            $data = $this->modelNews->getList(array("type"=>$type),array("date desc"),$limit);
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
            $type = $this->_request->getParam("type");
            $page = $this->_request->getParam("page", 1);
            if ($page < 1) $page = 1;
            $pageCount = 8;
            $offset = ($page - 1) * $pageCount;
            $limit = array($offset, $pageCount);
    
            $tag = array();
            $data = $this->modelNews->getList(array("type"=>$type),array("date desc"),$limit);
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