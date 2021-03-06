<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_HospitalizedSelectController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelHospitalizedSelect;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelHospitalizedSelect = new Application_Model_HospitalizedSelect();
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
    }

    /**
     * 数据列表接口
     */
    public function listAction()
    {
        /**
         * 查询条件准备
         */
        $where = '1=1';
        $category = $this->_request->getParam('category');
        if ($category) {
            $where .= " AND category='{$category}'";
        }
        
        /**
         * 排序条件
         */
        $order = array(
            'id ASC',
        );
        
        /**
         * 分页参数
         */
        $page = $this->_request->getParam('page', 1);
        $page = (int)$page == 0 ? 1 : (int)$page;
        $pageCount = 10;
        $offset = ($page - 1) * $pageCount;
        $limit = array($offset, $pageCount);
        
        /**
         * 获得结果
         */
        $result = array();
        try {
            $hospitalizedSelectList = $this->modelHospitalizedSelect->getList($where, $order, $limit);
            if ($hospitalizedSelectList == null) {
                throw new Exception("No data matched.", 100);
            }
            $data = array();
            foreach ($hospitalizedSelectList as $hospitalizedSelect) {
                $single = array();
				$single['id'] = $hospitalizedSelect->id; // 数据ID
				$single['name'] = $hospitalizedSelect->name; // 姓名
				$single['card_no'] = $hospitalizedSelect->card_no; // 身份证号
				$single['date'] = $hospitalizedSelect->date; // 日期
                array_push($data, $single);
            }
        
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        
        echo Zend_Json::encode($result);
    }
    
    /**
     * 数据详情接口
     */
    public function detailAction()
    {
        $resut = array();
        $id = $this->_request->getParam('id');
        try {
            if ($id == null) {
                throw new Exception("Lack param: id", 100);
            }
            $hospitalizedSelect = $this->modelHospitalizedSelect->getSingle(array('id'=>$id));
            if ($hospitalizedSelect == null) {
                throw new Exception("No data matched your given id.", 303);
            } else {
                $single = array();
				$single['id'] = $hospitalizedSelect->id; // 数据ID
				$single['name'] = $hospitalizedSelect->name; // 姓名
				$single['card_no'] = $hospitalizedSelect->card_no; // 身份证号
				$single['date'] = $hospitalizedSelect->date; // 日期
                $result = array(
                    'code' => 200,
                    'msg' => '请求成功',
                    'data' => $single
                );
            }
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }

    /**
     * 数据新增接口
     */
    public function addAction()
    {
        $result = array();
        if ($this->getRequest()->isPost()) {
            try {
                $data = array();
				$data['name'] = $this->_request->getParam('name'); // 姓名
				$data['card_no'] = $this->_request->getParam('card_no'); // 身份证号
				$data['date'] = $this->_request->getParam('date'); // 日期

                $newid = $this->modelHospitalizedSelect->insert($data);
        
                $result = array('code' => 200, 'msg' => '提交成功', 'new_id'=>$newid);
            } catch (Exception $e) {
                $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
            }
        } else {
            $result = array('code' => '100', 'msg' => '非法提交');
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 数据更新接口
     */
    public function updateAction()
    {
        $result = array();
        if ($this->getRequest()->isPost()) {
            try {
                $id = $this->_request->getParam('id');
                if ($id == null) throw new Exception("Lack param: id", 101);
                
                $data = array();
				$data['name'] = $this->_request->getParam('name'); // 姓名
				$data['card_no'] = $this->_request->getParam('card_no'); // 身份证号
				$data['date'] = $this->_request->getParam('date'); // 日期

                $this->modelHospitalizedSelect->updateData($id, $data);
                $result = array('code' => 200, 'msg' => '更新成功');
            } catch (Exception $e) {
                $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
            }
        } else {
            $result = array('code' => '100', 'msg' => '非法提交');
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 数据删除接口
     */
    public function deleteAction()
    {
        $result = array();
        if ($this->getRequest()->isPost()) {
            try {
                $id = $this->_request->getParam('id');
                if ($id == null) throw new Exception("Lack param: id", 101);
                $this->modelHospitalizedSelect->deleteData($id);
                $result = array('code' => 200, 'msg' => '删除成功');
            } catch (Exception $e) {
                $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
            }
        } else {
            $result = array('code' => '100', 'msg' => '非法提交');
        }
        echo Zend_Json::encode($result);
    }
    
    
}













