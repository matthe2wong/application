<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_WebsiteController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelAbouts;
    private $modelHospitalNews;
    private $modelSection;
    private $modelDepartmentIntro;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelAbouts = new Application_Model_Abouts();
        $this->modelHospitalNews = new Application_Model_HospitalNews();
        $this->modelSection = new Application_Model_Section();
        $this->modelDepartmentIntro = new Application_Model_DepartmentIntro();
        $this->_helper->layout->setLayout('layout-wx-mui');
    }

    /**
     * 首页
     */
    public function indexAction()
    {
        
    }
    
    /**
     * 来院导引
     */
    public function routeAction()
    {
        $this->view->data = $this->modelAbouts->getSingle(array("id"=>1));
    }
    
    
    /**
     * 医生介绍
     */
    public function doctorIntroAction()
    {
        $this->view->section= $this->modelSection->getList(array("parent_code"=>0));
    }
    
    /**
     * 获取科室
     */
    public function sectionAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
//         header('Content-type: application/json');
        $result = array();
        try { 
            $data = array();
            $code = $this->_request->getParam('code');
            
            $data = $this->modelSection->getList(array("parent_code"=>$code));
            $result = array('code' => 200, 'msg' => '请求成功','data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 医生列表
     */
    public function doctorListAction()
    {
    
    }
    
    /**
     * 医生详情
     */
    public function doctorDetailAction()
    {
    
    }
    
    /**
     * 医院动态
     */
    public function listAction(){
        $this->view->jkxj = $this->modelHospitalNews->getList(array("type"=>"健康宣教"));
        $this->view->yydt = $this->modelHospitalNews->getList(array("type"=>"医院动态"));
    }
    
    /**
     * 详情页
     */
    public function listDetailAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelHospitalNews->getSingle(array("id"=>$id));
    }
    
    /**
     * 详情页
     */
    public function detailAction()
    {
        $this->view->data = $this->modelAbouts->getSingle(array("id"=>1));
    }
    

    /**
     * 科室分布
     */
    public function sectionAction()
    {
        $this->view->data = $this->modelDepartmentIntro->getList(array());
    }
    
    /**
     * 楼群分布
     */
    public function towerAction()
    {
    
    }
    
    /**
     * 来院导航
     */
    public function mapAction()
    {
        
    }
    
    /**
     * name:资讯列表按年份分类
     *
     */
    public function newsListAction()
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
            $data = $this->modelHospitalNews->getList(array("type"=>$type),array("date desc"),$limit);
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
     * author:尚宁
     *
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
            $data = $this->modelHospitalNews->getList(array("type"=>$type),array("date desc"),$limit);
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













