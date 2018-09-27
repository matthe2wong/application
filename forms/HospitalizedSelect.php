<?php
/**
 * 业务表单-[表单名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Form_HospitalizedSelect extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
    	
        $this->addElement('text', 'name', array(
            'label'         =>  '姓名',
            'placeholder'   =>  '请输入姓名',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'card_no', array(
            'label'         =>  '身份证号',
            'placeholder'   =>  '请输入身份证号',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'date', array(
            'label'         =>  '日期',
            'placeholder'   =>  '请输入日期',
            'class'         =>  'form-control szkj-form-control datetimepicker',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
			'data-date-format'	=>	'yyyy-mm-dd hh:ii:ss',
			'value'	=>	date("Y-m-d H:i:s"),
			'data-start-view'	=>	'month',
			'data-min-view'	=>	'month',
			'data-max-view'	=>	'decade',
        ));
        // 开启datetimepicker组件
        $this->addAttribs( array(
            'load_datetimepicker' => true,
        ) );

    	 
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'class'    => 'btn btn-primary',
            'label'    => '保存',
        ));
    	
    	// And finally add some CSRF protection
//     	$this->addElement('hash', 'csrf', array(
//     			'ignore' => true,
//     	));
    	 
    	// 表单装饰器
    	$this->setElementDecorators(array(
    	    array('Label', array('class'=>'control-label', 'requiredSuffix'=>' （*必填项）')),
    	    'ViewHelper',
    	    array('Errors', array('class'=>'alert alert-error')),
    	    array( array( 'wrapper1' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'form-group' ) ),
    	    array( array( 'wrapper2' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'col-lg-3 col-md-4 col-sm-6 col-xs-12' ) ),
    	), array(), false);
    	
    	$this->setDecorators(array(
    			'FormElements',
    			array('HtmlTag', array('class'=>'row')),
    			array('Form',array('class'=>'zend-form')),
    	));
    	
    	$this->getElement('submit')->removeDecorator('Label')
    	->removeDecorator('wrapper1')->removeDecorator('wrapper2')
    	->addDecorator('HtmlTag', array('class'=>'col-xs-12'));
    }


}

