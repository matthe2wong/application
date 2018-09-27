<?php
/**
 * 业务表单-[表单名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Form_SysMenu extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
    	
		$this->addElement('text','title',array(
			'label'			=>	'菜单名称',
			'placeholder'	=>	'请输入菜单名称',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));
		$this->addElement('text','icon',array(
			'label'			=>	'图标',
			'placeholder'	=>	'请输入图标',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));
		$this->addElement('text','order_no',array(
			'label'			=>	'显示顺序',
			'placeholder'	=>	'请输入显示顺序',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));
		$this->addElement('text','level',array(
			'label'			=>	'菜单级别',
			'placeholder'	=>	'请输入菜单级别',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));
		$this->addElement('text','parent_id',array(
			'label'			=>	'上级菜单ID',
			'placeholder'	=>	'请输入上级菜单ID',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));
		$this->addElement('text','type',array(
			'label'			=>	'菜单类型',
			'placeholder'	=>	'请输入菜单类型',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));
		$this->addElement('text','url',array(
			'label'			=>	'链接地址',
			'placeholder'	=>	'请输入链接地址',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));
		$this->addElement('text','role_id',array(
			'label'			=>	'角色ID',
			'placeholder'	=>	'请输入角色ID',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));
		$this->addElement('text','status',array(
			'label'			=>	'菜单状态',
			'placeholder'	=>	'请输入菜单状态',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));
		$this->addElement('text','note',array(
			'label'			=>	'备注',
			'placeholder'	=>	'请输入备注',
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
    			array('Form',array('class'=>'form-horizontal form-bordered')),
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

