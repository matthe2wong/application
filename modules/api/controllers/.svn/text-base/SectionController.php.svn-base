<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_SectionController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelSection;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelSection = new Application_Model_Section();
    }

    /**
     * zf_section
     * 获得父级下的子级科室
     */
    public function getChildSectionAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $result = array();
        if ($this->getRequest()->isPost()) {
            try {
                $data_code = $this->_request->getParam('data_code');
                if ($data_code == null) throw new Exception("Lack param: code", 101);
                $data = $this->modelSection->getList(array("parent_code"=>$data_code));
                if(!$data)throw new Exception("暂无信息", 101);
                $data = $data->toArray();
                $result = array('code' => 200, 'msg' => '请求成功',"data"=>$data);
            } catch (Exception $e) {
                $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
            }
        } else {
            $result = array('code' => '100', 'msg' => '非法提交');
        }
        echo Zend_Json::encode($result);
    }
    
    
}













