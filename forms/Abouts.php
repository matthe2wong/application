<?php
/**
 * 业务表单-[表单名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Form_Abouts extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
    	
        $this->addElement('text', 'title', array(
            'label'         =>  '标题',
            'placeholder'   =>  '请输入标题',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '6-8-12-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'class', array(
            'label'         =>  '等级',
            'placeholder'   =>  '请输入等级',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'phone', array(
            'label'         =>  '电话',
            'placeholder'   =>  '请输入电话',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'address', array(
            'label'         =>  '地址',
            'placeholder'   =>  '请输入地址',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '6-8-12-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('textarea', 'intro', array(
            'label'         =>  '介绍',
            'placeholder'   =>  '请输入介绍',
            'class'         =>  'szkj-form-control',
            'colspan'       =>  '12-12-12-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        // 开启ueditor组件
        $this->addAttribs( array(
            'load_ueditor' => true,
            'ueditor_list' => array(
                array('name' => 'intro', 'toolbar' => 'min'),
            )
        ));

    	 
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

