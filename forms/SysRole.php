<?php
/**
 * 业务表单-[表单名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Form_SysRole extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
    	
		$this->addElement('text','name',array(
			'label'			=>	'角色名称',
			'placeholder'	=>	'请输入角色名称',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));

		$this->addElement('text','layout_admin',array(
			'label'			=>	'管理界面布局',
			'placeholder'	=>	'请输入管理界面布局',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));

    	 
    	// And finally add some CSRF protection
//     	$this->addElement('hash', 'csrf', array(
//     			'ignore' => true,
//     	));
    	 
    	// 表单装饰器
    	$this->setElementDecorators(array(
    			'ViewHelper',
    			array('Errors', array('class'=>'alert alert-error')),
    			array('HtmlTag',array('class'=>'col-sm-10 form-group')),
    			array('Label', array('class'=>'col-sm-2 control-label')),
    	));
    	
    	$this->setDecorators(array(
    			'FormElements',
    			'HtmlTag',
    			array('Form',array('class'=>'form-horizontal')),
    	));
    	

    	
    	$this->addElement('submit', 'submit', array(
    			'ignore'   => true,
    			'class'    => 'btn btn-success',
    			'label'    => '提交',
    	));
    	$this->getElement('submit')->addDecorator('HtmlTag',array('class'=>'col-sm-offset-2 col-sm-10 col-xs-12'));
     	$this->getElement('submit')->removeDecorator('Label');
    }


}

