<?php
/**
 * 业务表单-[表单名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Form_Slides extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
    	
        // 轮播图（上传组件）
        $relativeDir = '/uploads/'.date('ymd');
        $absoluteDir = APPLICATION_PATH."/../public".$relativeDir;
        if (!is_dir($absoluteDir)) mkdir($absoluteDir);
        $this->addElement('file', 'thumb', array(
            'relative_dir' => $relativeDir,
    	    'label'      => '轮播图',
    	    'destination' => $absoluteDir,
    	    'class'      => 'form-control szkj-form-control',
    	    'colspan'    =>  '3-4-6-12',
    	    'required'   => false,
    	    'validators' => array(
    	        'Count' => array(false, 1),
    	        'Size' => array(false, 10 * 1024 * 1024),
    	        //'Extension' => array(false, 'jpg,png,gif'),
    	    ),
    	    'decorators' => array(new Zend_Form_Decorator_File()),
    	));
    	$this->getElement('thumb')->setDecorators(array(
    	    'File',
    	    array(
    	        'ViewScript',
    	        array(
    	            'viewScript' => 'decorators/file.phtml',
    	            'placement' => false
    	        )
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
    	), array('thumb'), false);
    	
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

