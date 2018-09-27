<?php
/**
 * 数据表模型-[模型名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Model_WxMenu extends Application_Model_Base
{
    /**
     * 对应数据表名称
     */
    protected $_name = 'zf_wx_menu';
    
    /**
     * 增加数据
     * @param Zend_Form $form
     * @return mixed
     */
    public function insertByForm($form)
    {
        $formData = $this->preprocessFormData($this->processForm($form));
        $newid = $this->insert($formData);
        return $newid;
    }
    
    /**
     * 更新数据
     * @param Zend_Form $form
     * @param int $id
     */
    public function updateByForm($form, $id)
    {
        $formData =  $this->preprocessFormData($this->processForm($form));
        return $this->updateData($id, $formData);
    }
    
    /**
     * 预处理表单数据
     * @param array $formData
     */
    public function preprocessFormData($formData)
    {
        return $formData;
    }
}

