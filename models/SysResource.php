<?php
/**
 * 数据表模型-系统资源
 * @author liujin
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Model_SysResource extends Application_Model_Base
{
    /**
     * 对应数据表名称
     */
    protected $_name = 'zf_sys_resource';
    
    /**
     * 根据URL获得对应的资源
     *
     * @param obj $url
     * @return obj
     */
    public function getResourceByUrl($url)
    {
        $resource = null;
    
        $parts = explode('/', $url);
        $moduleName = '';
        $controllerName = '';
        $actionName = '';
    
        if (count($parts) == 3) {
            $moduleName = 'default';
            $controllerName = $parts[1];
            $actionName = $parts[2];
        }
        if (count($parts) == 4) {
            $moduleName = $parts[1];
            $controllerName = $parts[2];
            $actionName = $parts[3];
        }
        if ($moduleName != '' && $controllerName != '' && $actionName != '') {
            $resource = $this->getSingle(array(
                'module' => $moduleName,
                'controller' => $controllerName,
                'action' => $actionName
            ));
        }
    
        return $resource;
    }
    
    /**
     * 根据请求对象获得对应的资源
     * @param obj $request
     * @return NULL|integer
     */
    public function getResourceByRequest($request)
    {
        $currentModuleName = $request->getModuleName();
        $currentControllerName = $request->getControllerName();
        $currentActionName = $request->getActionName();
        
        $currentResource = $this->getSingle(
            array(
                'module'=>$currentModuleName,
                'controller'=>$currentControllerName,
                'action'=>$currentActionName)
        );
        
        return $currentResource;
    }
    
    /**
     * 根据请求对象获得对应的资源ID
     * @param obj $request
     * @return NULL|integer
     */
    public function getResourceIdByRequest($request)
    {
        $resourceId = null;
        
        $currentResource = $this->getResourceByRequest($request);
        
        if ($currentResource) {
            $resourceId = $currentResource->id;
        }
        
        return $resourceId;
    }
    

    /**
     * 获取所有的分组名称
     */  
    public function getGroupNameList(){
        $sql="SELECT DISTINCT(group_name) FROM ".$this->_name." ORDER BY weight DESC,id ASC";
        return $this->rawQuery($sql);
    }
    
    /**
     * 获取可作为菜单的所有资源
     */
    public function getMenuResourceList(){
        return $this->getList("is_menu = 1");
    }
    /**
     * 获取本权限下的可选菜单
     * @param unknown $groupName
     */
    public function getGroupNameMenuResource($groupName){
        return $this->getList(array('group_name'=>$groupName,'is_menu'=>1));
    }
    
    
}

