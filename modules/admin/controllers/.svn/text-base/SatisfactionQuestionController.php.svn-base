<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_SatisfactionQuestionController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelSatisfactionQuestion;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelSatisfactionQuestion = new Admin_Model_SatisfactionQuestion();
        
        $this->_helper->layout->setLayout('layout-admin');
    }

    /**
     * 默认页
     */
    public function indexAction()
    {
        // action body
    }
    
   
    /**
     * 管理列表页
     */
    public function manageAction()
    {
        // 查询条件
        $id = $this->_request->getParam('sid');
        $where = $this->getWhereStr()." and satisfaction_id=$id";
        
        // 排序条件
        $order = array();
        
        /**
         * 获得数据
         */
        $data = $this->modelSatisfactionQuestion->getList($where,$order);
        if ($data != null) {
            $this->view->data = $data;
            

        }
        $this->view->sid = $id;
    }
    
    /**
     * 数据导入
     */
    public function importAction()
    {
        $this->view->messages = array();
        if ($this->_request->isPost() && isset($_FILES["data-file-upload"])) {
            $dataFile = $_FILES["data-file-upload"];
            if ($dataFile['error'] == 0) {
                $tempFileName = APPLICATION_PATH.'/../public/uploads/temp.xlsx';
                move_uploaded_file($dataFile["tmp_name"], $tempFileName);
                $isSuccess = $this->modelSatisfactionQuestion->importExcel($tempFileName);
                if ($isSuccess == true) {
                    $this->view->messages[] = array(
                        "恭喜您，数据导入成功！", 'success');
                } else {
                    $this->view->messages[] = array(
                        "导入数据出错，请确认数据文件正确后尝试再次导入！", 'danger');
                }
            }
        }
    }
    
    /**
     * 数据导出
     */
    public function exportAction()
    {
        $this->_helper->layout()->disableLayout();
        header ( "Content-type:application/vnd.ms-excel" );
        header ( "Content-Disposition:filename=满意度调查问题".date("YmdHis").".xls" );
        
        // 查询条件
        $where = $this->getWhereStr();
        
        // 排序条件
        $order = array('id ASC');
        
        $data = $this->modelSatisfactionQuestion->getList($where, $order);
        $this->view->data = $data;

    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelSatisfactionQuestion->getSingle(array("id"=>$id));
    }

    /**
     * 数据统计页
     */
    public function statisticsAction()
    {
        // 获取总记录数量
        $this->view->totalRowsCount = $this->modelSatisfactionQuestion->getCount();
        
        $modelBase = new Application_Model_Base();
        $tableName = 'zf_satisfaction_question';
        // 根据满意度调查ID统计
        $sql = "SELECT satisfaction_id, count(*) as count FROM $tableName GROUP BY satisfaction_id ORDER BY count DESC";
        $this->view->dataSatisfactionId = $modelBase->rawQuery($sql);
        // 根据问题名称统计
        $sql = "SELECT question, count(*) as count FROM $tableName GROUP BY question ORDER BY count DESC";
        $this->view->dataQuestion = $modelBase->rawQuery($sql);

    }
    
    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_SatisfactionQuestion();
        $sid = $this->_request->getParam('sid');
        $extra = array("satisfaction_id"=>$sid);
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $newid = $this->modelSatisfactionQuestion->insertByForm($form, $extra);
                $this->_redirect($this->_helper->url('manage/sid/'.$sid));
            }
        }
        $this->view->form = $form;
    }
    
    /**
     * 数据编辑页（Zend Form）
     */
    public function editAction()
    {
        $id = $this->_request->getParam('id');
        $sid = $this->_request->getParam('sid');
        $form = new Application_Form_SatisfactionQuestion();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $result = $this->modelSatisfactionQuestion->updateByForm($form, $id);
                if ($result) {
                    return $this->_redirect($this->_helper->url('manage/sid/'.$sid));
                }
            }
        }
         
        $oldData = $this->modelSatisfactionQuestion->getSingle(array('id'=>$id));
        $form->populate($oldData->toArray());
    
        $this->view->form = $form;
        $this->view->data = $oldData;
    }
    
    /**
     * 数据删除请求
     */
    public function deleteAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $result = array();
        if ($this->getRequest()->isPost()) {
            try {
                $id = $this->_request->getParam('id');
                $this->modelSatisfactionQuestion->deleteData($id);
                $result = array('code' => 200, 'msg' => '删除成功');
            } catch (Exception $e) {
                $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
            }
        } else {
            $result = array('code' => '100', 'msg' => '非法提交');
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 获得查询条件
     */
    private function getWhereStr()
    {
        $where = '1=1';
        $id = $this->_request->getParam('id');
        if (isset($id)) {
            $where .= " AND id='{$id}'";
            $this->view->search_value_id = $id;
        }
        $satisfaction_id = $this->_request->getParam('satisfaction_id');
        if (isset($satisfaction_id)) {
            $where .= " AND satisfaction_id='{$satisfaction_id}'";
            $this->view->search_value_satisfaction_id = $satisfaction_id;
        }
        $question = $this->_request->getParam('question');
        if (isset($question)) {
            $where .= " AND question LIKE '%{$question}%'";
            $this->view->search_value_question = $question;
        }

        return $where;
    }
    
}