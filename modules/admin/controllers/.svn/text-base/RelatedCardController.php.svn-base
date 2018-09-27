<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_RelatedCardController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelRelatedCard;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelRelatedCard = new Admin_Model_RelatedCard();
        
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
        $where = $this->getWhereStr();
        
        // 排序条件
        $order = array();
        
        /**
         * 获得数据
         */
        $data = $this->modelRelatedCard->getList($where,$order);
        if ($data != null) {
            $this->view->data = $data;
            

        }
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
                $isSuccess = $this->modelRelatedCard->importExcel($tempFileName);
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
        header ( "Content-Disposition:filename=预约挂号".date("YmdHis").".xls" );
        
        // 查询条件
        $where = $this->getWhereStr();
        
        // 排序条件
        $order = array('id ASC');
        
        $data = $this->modelRelatedCard->getList($where, $order);
        $this->view->data = $data;

    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelRelatedCard->getSingle(array("id"=>$id));
    }

    /**
     * 数据统计页
     */
    public function statisticsAction()
    {
        // 获取总记录数量
        $this->view->totalRowsCount = $this->modelRelatedCard->getCount();
        
        $modelBase = new Application_Model_Base();
        $tableName = 'zf_related_card';
        // 根据用户ID统计
        $sql = "SELECT user_id, count(*) as count FROM $tableName GROUP BY user_id ORDER BY count DESC";
        $this->view->dataUserId = $modelBase->rawQuery($sql);
        // 根据OPENID统计
        $sql = "SELECT openid, count(*) as count FROM $tableName GROUP BY openid ORDER BY count DESC";
        $this->view->dataOpenid = $modelBase->rawQuery($sql);
        // 根据姓名统计
        $sql = "SELECT name, count(*) as count FROM $tableName GROUP BY name ORDER BY count DESC";
        $this->view->dataName = $modelBase->rawQuery($sql);
        // 根据身份证号统计
        $sql = "SELECT identity_card, count(*) as count FROM $tableName GROUP BY identity_card ORDER BY count DESC";
        $this->view->dataIdentityCard = $modelBase->rawQuery($sql);
        // 根据卡号统计
        $sql = "SELECT card_no, count(*) as count FROM $tableName GROUP BY card_no ORDER BY count DESC";
        $this->view->dataCardNo = $modelBase->rawQuery($sql);
        // 根据日期统计
        $sql = "SELECT date, count(*) as count FROM $tableName GROUP BY date ORDER BY count DESC";
        $this->view->dataDate = $modelBase->rawQuery($sql);

    }
    
    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_RelatedCard();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $newid = $this->modelRelatedCard->insertByForm($form, $extra);
                $this->_redirect($this->_helper->url('manage'));
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
        $form = new Application_Form_RelatedCard();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $result = $this->modelRelatedCard->updateByForm($form, $id);
                if ($result) {
                    return $this->_redirect($this->_helper->url('manage'));
                }
            }
        }
         
        $oldData = $this->modelRelatedCard->getSingle(array('id'=>$id));
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
                $this->modelRelatedCard->deleteData($id);
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
        $user_id = $this->_request->getParam('user_id');
        if (isset($user_id)) {
            $where .= " AND user_id='{$user_id}'";
            $this->view->search_value_user_id = $user_id;
        }
        $openid = $this->_request->getParam('openid');
        if (isset($openid)) {
            $where .= " AND openid LIKE '%{$openid}%'";
            $this->view->search_value_openid = $openid;
        }
        $name = $this->_request->getParam('name');
        if (isset($name)) {
            $where .= " AND name LIKE '%{$name}%'";
            $this->view->search_value_name = $name;
        }
        $identity_card = $this->_request->getParam('identity_card');
        if (isset($identity_card)) {
            $where .= " AND identity_card LIKE '%{$identity_card}%'";
            $this->view->search_value_identity_card = $identity_card;
        }
        $card_no = $this->_request->getParam('card_no');
        if (isset($card_no)) {
            $where .= " AND card_no LIKE '%{$card_no}%'";
            $this->view->search_value_card_no = $card_no;
        }
        $date = $this->_request->getParam('date');
        if (isset($date)) {
            $where .= " AND date LIKE '%{$date}%'";
            $this->view->search_value_date = $date;
        }

        return $where;
    }
    
}