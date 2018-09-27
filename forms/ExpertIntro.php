<?php
/**
 * 业务表单-[表单名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Form_ExpertIntro extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $modelXtDictionary = new Application_Model_Section();
    	
        $this->addElement('text', 'name', array(
            'label'         =>  '姓名',
            'placeholder'   =>  '请输入姓名',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        // 照片（上传组件）
        $image_element = new Zend_Form_Element_File('photo');
        $image_element->setLabel('专家照片')
        ->setDestination('../public/uploads/img');
        $image_element->addValidator('Count', false, array('min' => 0, 'max' => 3));
        $image_element->addValidator('Size', false, 1024*1024*10);
        $image_element->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $image_element->setMultiFile(1);
        $image_element->setAttrib('relative_dir','/uploads/img');
        $image_element->setAttrib('class', 'form-control');
        
        $image_element->setDecorators(array(new Zend_Form_Decorator_File()));
        $this->addElement($image_element, 'photo'
            );
        $this->getElement('photo')->setDecorators(array(
            'File',
            array(
                'ViewScript',
                array(
                    'viewScript' => 'decorators/file.phtml',
                    'placement' => false,
                ),
            ),
            
        ));
        $this->addElement('select', 'department_id', array(
            'label'         =>  '选择科室',
            'placeholder'   =>  '请输入选择科室',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
            'multiOptions'  => $modelXtDictionary->getSelectOptions(),
        ));
       
        $this->addElement('text', 'position', array(
            'label'         =>  '职位',
            'placeholder'   =>  '请输入职位',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
       
        $this->addElement('textarea', 'skill', array(
            'label'         =>  '擅长',
            'placeholder'   =>  '请输入擅长',
            'class'         =>  'szkj-form-control',
            'colspan'       =>  '12-12-12-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('textarea', 'intro', array(
            'label'         =>  '简介',
            'placeholder'   =>  '请输入简介',
            'class'         =>  'szkj-form-control',
            'colspan'       =>  '12-12-12-12',
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
			'data-date-format'	=>	'yyyy-mm-dd',
			'value'	=>	date("Y-m-d"),
			'data-start-view'	=>	'month',
			'data-min-view'	=>	'month',
			'data-max-view'	=>	'decade',
        ));
        // 开启ueditor组件
        $this->addAttribs( array(
            'load_ueditor' => true,
            'ueditor_list' => array(
                array('name' => 'skill', 'toolbar' => 'min'),
array('name' => 'intro', 'toolbar' => 'min'),
            )
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
    	), array('photo'), false);
    	
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

