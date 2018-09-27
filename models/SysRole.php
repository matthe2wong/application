<?php
/**
 * 数据表模型-[模型名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Model_SysRole extends Application_Model_Base
{
    /**
     * 对应数据表名称
     */
    protected $_name = 'zf_sys_role';
    
    /**
     * 根据数据字典名称获得下拉菜单选项数组（带CODE）
     * @param string $name
     * @return array
     */
    public static function getMultiOptions()
    {
        $options = array();
        $obj = new Application_Model_SysRole();
        $list = $obj->getList();
        if ($list) {
            foreach ($list as $d) {
                $options[$d->id] = $d->name;
            }
        }
        return $options;
    }
    
    /**
     * 根据角色ID获得角色名称
     * @param int $id
     * @return string
     */
    public static function getRoleNameById($id)
    {
        $name = "";
        $model = new Application_Model_SysRole();
        $role = $model->getSingle(array('id'=>$id));
        if($role)
        {
            $name = $role->name;
        }
        return $name;
    
    }
}

