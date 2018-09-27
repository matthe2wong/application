<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $this->_redirect('/admin');
    }

    /**
     * 数据库备份
     */
    public function dbdumpAction()
    {
        /**
         * 读取配置文件中的数据库配置
         */
        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','production');
        $dbParams = $config->resources->db->params;
        /**
         * 调用数据库备份助手导出SQL文件，默认存放在public下的dbdump目录
         */
        $dumpHelper = new Szkj_Helper_DatabaseDump();
        $dumpHelper->db_dump($dbParams->host, $dbParams->username, $dbParams->password, $dbParams->dbname);
        exit;
    }

}





