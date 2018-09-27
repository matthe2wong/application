<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_ExpertIntroController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelExpertIntro;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelExpertIntro = new Admin_Model_ExpertIntro();
        
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
        $data = $this->modelExpertIntro->getList($where,$order);
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
                $isSuccess = $this->modelExpertIntro->importExcel($tempFileName);
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
        header ( "Content-Disposition:filename=专家介绍".date("YmdHis").".xls" );
        
        // 查询条件
        $where = $this->getWhereStr();
        
        // 排序条件
        $order = array('id ASC');
        
        $data = $this->modelExpertIntro->getList($where, $order);
        $this->view->data = $data;

    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelExpertIntro->getSingle(array("id"=>$id));
    }

    /**
     * 数据统计页
     */
    public function statisticsAction()
    {
        // 获取总记录数量
        $this->view->totalRowsCount = $this->modelExpertIntro->getCount();
        
        $modelBase = new Application_Model_Base();
        $tableName = 'zf_expert_intro';
        // 根据类型统计
        $sql = "SELECT department, count(*) as count FROM $tableName GROUP BY department ORDER BY count DESC";
        $this->view->dataDepartment = $modelBase->rawQuery($sql);
        // 根据职位统计
        $sql = "SELECT position, count(*) as count FROM $tableName GROUP BY position ORDER BY count DESC";
        $this->view->dataPosition = $modelBase->rawQuery($sql);
        // 根据姓名统计
        $sql = "SELECT name, count(*) as count FROM $tableName GROUP BY name ORDER BY count DESC";
        $this->view->dataName = $modelBase->rawQuery($sql);
        // 根据照片统计
        $sql = "SELECT photo, count(*) as count FROM $tableName GROUP BY photo ORDER BY count DESC";
        $this->view->dataPhoto = $modelBase->rawQuery($sql);
        // 根据擅长统计
        $sql = "SELECT skill, count(*) as count FROM $tableName GROUP BY skill ORDER BY count DESC";
        $this->view->dataSkill = $modelBase->rawQuery($sql);
        // 根据简介统计
        $sql = "SELECT intro, count(*) as count FROM $tableName GROUP BY intro ORDER BY count DESC";
        $this->view->dataIntro = $modelBase->rawQuery($sql);
        // 根据日期统计
        $sql = "SELECT date, count(*) as count FROM $tableName GROUP BY date ORDER BY count DESC";
        $this->view->dataDate = $modelBase->rawQuery($sql);

    }
    
    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_ExpertIntro();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $newid = $this->modelExpertIntro->insertByForm($form, $extra);
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
        $form = new Application_Form_ExpertIntro();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $result = $this->modelExpertIntro->updateByForm($form, $id);
                if ($result) {
                    return $this->_redirect($this->_helper->url('manage'));
                }
            }
        }
         
        $oldData = $this->modelExpertIntro->getSingle(array('id'=>$id));
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
                $this->modelExpertIntro->deleteData($id);
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
        $department = $this->_request->getParam('department');
        if (isset($department)) {
            $where .= " AND department LIKE '%{$department}%'";
            $this->view->search_value_department = $department;
        }
        $position = $this->_request->getParam('position');
        if (isset($position)) {
            $where .= " AND position LIKE '%{$position}%'";
            $this->view->search_value_position = $position;
        }
        $name = $this->_request->getParam('name');
        if (isset($name)) {
            $where .= " AND name LIKE '%{$name}%'";
            $this->view->search_value_name = $name;
        }
        $skill = $this->_request->getParam('skill');
        if (isset($skill)) {
            $where .= " AND skill LIKE '%{$skill}%'";
            $this->view->search_value_skill = $skill;
        }
        $intro = $this->_request->getParam('intro');
        if (isset($intro)) {
            $where .= " AND intro LIKE '%{$intro}%'";
            $this->view->search_value_intro = $intro;
        }
        $date_min = $this->_request->getParam('date_min');
        if (isset($date_min)) {
            $where .= " AND date>'{$date_min} 00:00:00'";
            $this->view->search_value_date_min = $date_min;
        }
        $date_max = $this->_request->getParam('date_max');
        if (isset($date_max)) {
            $where .= " AND date<'{$date_max} 23:59:59'";
            $this->view->search_value_date_max = $date_max;
        }

        return $where;
    }
    
}