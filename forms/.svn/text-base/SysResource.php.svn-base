<?php
/**
 * 业务表单-[表单名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Form_SysResource extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
    	
		$this->addElement('text','title',array(
			'label'			=>	'名称',
			'placeholder'	=>	'请输入名称',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));

		$this->addElement('text','module',array(
			'label'			=>	'模块',
			'placeholder'	=>	'请输入模块',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));

		$this->addElement('text','controller',array(
			'label'			=>	'控制器',
			'placeholder'	=>	'请输入控制器',
			'class'			=>	'form-control',
			'required'		=>	false,
			'filters'		=>	array('StringTrim'),
		));

		$this->addElement('text','action',array(
			'label'			=>	'动作',
			'placeholder'	=>	'请输入动作',
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

