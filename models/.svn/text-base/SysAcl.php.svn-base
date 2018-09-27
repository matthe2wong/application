<?php
/**
 * 数据表模型-权限控制
 * @author liujin
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Model_SysAcl extends Application_Model_Base
{
    /**
     * 对应数据表名称
     */
    protected $_name = 'zf_sys_acl';
    
    /**
     * 增加或删除权限
     * @param int $roleId
     * @param int $resourceId
     */
    public function changeAcl($roleId,$resourceId){
        if (!$roleId) {
            throw new Exception('角色ID获取失败',100);
        }
        if (!$resourceId) {
            throw new Exception('资源ID获取失败',100);
        }
        $newResourceId=null;
        $data = array( 
            "resource_id" => $resourceId,
            "role_id" => $roleId
        );
        $where="resource_id='{$resourceId}' AND role_id='{$roleId}'";
        $resources = $this->getList($where);
        if ($resources) {
            $newResourceId = $this->delete($where);
        }else {
            $newResourceId = $this->insert($data);
        }
        return $newResourceId;
    }
    
    
    
}

