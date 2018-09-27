<?php
/**
 * 数据表模型-[模型名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_Model_Specialist extends Application_Model_Specialist
{
    /**
     * 增加数据
     * @param Zend_Form $form
     * @return mixed
     */
    public function insertByForm($form, $extra=array())
    {
        $formData = $this->preprocessFormData($this->processForm($form));
        $formData = array_merge($formData, $extra);
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

