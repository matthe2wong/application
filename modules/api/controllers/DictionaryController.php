<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_DictionaryController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelDictionary;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelDictionary = new Application_Model_Dictionary();
        
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
            $dictionaryList = $this->modelDictionary->getList($where, $order, $limit);
            if ($dictionaryList == null) {
                throw new Exception("No data matched.", 100);
            }
            $data = array();
            foreach ($dictionaryList as $dictionary) {
                $single = array();
				$single['id'] = $dictionary->id; // 数据ID
				$single['data_code'] = $dictionary->data_code; // 数据编码
				$single['parent_code'] = $dictionary->parent_code; // 父级编码
				$single['data_name'] = $dictionary->data_name; // 数据名称
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
            $dictionary = $this->modelDictionary->getSingle(array('id'=>$id));
            if ($dictionary == null) {
                throw new Exception("No data matched your given id.", 303);
            } else {
                $single = array();
				$single['id'] = $dictionary->id; // 数据ID
				$single['data_code'] = $dictionary->data_code; // 数据编码
				$single['parent_code'] = $dictionary->parent_code; // 父级编码
				$single['data_name'] = $dictionary->data_name; // 数据名称
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
				$data['data_code'] = $this->_request->getParam('data_code'); // 数据编码
				$data['parent_code'] = $this->_request->getParam('parent_code'); // 父级编码
				$data['data_name'] = $this->_request->getParam('data_name'); // 数据名称

                $newid = $this->modelDictionary->insert($data);
        
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
				$data['data_code'] = $this->_request->getParam('data_code'); // 数据编码
				$data['parent_code'] = $this->_request->getParam('parent_code'); // 父级编码
				$data['data_name'] = $this->_request->getParam('data_name'); // 数据名称

                $this->modelDictionary->updateData($id, $data);
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
                $this->modelDictionary->deleteData($id);
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













