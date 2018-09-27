<?php
/**
 * 数据表模型-[模型名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Model_Section extends Application_Model_Base
{
    /**
     * 对应数据表名称
     */
    protected $_name = 'zf_section';
    
    /**
     * 获得用于下拉菜单的选项列表
     * @param string $datacode
     * @param bool $useCodeAsValue 是否以datacode作为选项值
     * @return array 
     */
    public function getSelectOptions($useCodeAsValue=false)
    {
        $model = new Application_Model_Section();
        $options = array();
        $dictionaryList = $model->getList();
        if ($dictionaryList): foreach ($dictionaryList as $dictionary) {
            $key = $dictionary->sid;
            $value = $dictionary->data_name;
            $options[$key] = $value;
        } endif;
        return $options;
    }
    
    
    /**
     * 获得用于下拉菜单的选项列表
     * @param string $datacode
     * @param bool $useCodeAsValue 是否以datacode作为选项值
     * @return array
     */
    public function getSelectOptions2($useCodeAsValue=false)
    {
        $model = new Application_Model_Section();
        $options = array();
        $dictionaryList = $model->getList(" parent_code != 0");
        if ($dictionaryList): foreach ($dictionaryList as $dictionary) {
            $key = $dictionary->data_name;
            $value = $dictionary->data_name;
            $options[$key] = $value;
        } endif;
        return $options;
    }
    
}

