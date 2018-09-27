<?php
/**
 * 业务表单-[表单名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Form_RegistrationCancel extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
    	
        $this->addElement('text', 'user_id', array(
            'label'         =>  '用户ID',
            'placeholder'   =>  '请输入用户ID',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'openid', array(
            'label'         =>  'openid',
            'placeholder'   =>  '请输入openid',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '6-8-12-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'time', array(
            'label'         =>  '就诊时段',
            'placeholder'   =>  '请输入就诊时段',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '6-8-12-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'type', array(
            'label'         =>  '费用类型',
            'placeholder'   =>  '请输入费用类型',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'hospital_name', array(
            'label'         =>  '医院名称',
            'placeholder'   =>  '请输入医院名称',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'department', array(
            'label'         =>  '就诊科室',
            'placeholder'   =>  '请输入就诊科室',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'address', array(
            'label'         =>  '科室位置',
            'placeholder'   =>  '请输入科室位置',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'doctor_name', array(
            'label'         =>  '医生姓名',
            'placeholder'   =>  '请输入医生姓名',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'doctor_call', array(
            'label'         =>  '医生职称',
            'placeholder'   =>  '请输入医生职称',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'name', array(
            'label'         =>  '就诊人',
            'placeholder'   =>  '请输入就诊人',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'is_patient_card', array(
            'label'         =>  '是否有就诊卡',
            'placeholder'   =>  '请输入是否有就诊卡',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'hospital_number', array(
            'label'         =>  '医院单号',
            'placeholder'   =>  '请输入医院单号',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'platform_number', array(
            'label'         =>  '平台单号',
            'placeholder'   =>  '请输入平台单号',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'price', array(
            'label'         =>  '交易金额',
            'placeholder'   =>  '请输入交易金额',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'pay_status', array(
            'label'         =>  '支付状态',
            'placeholder'   =>  '请输入支付状态',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '3-4-6-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
        ));
        $this->addElement('text', 'appointment_time', array(
            'label'         =>  '预约时间',
            'placeholder'   =>  '请输入预约时间',
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
        $this->addElement('text', 'cancel_time', array(
            'label'         =>  '取消时间',
            'placeholder'   =>  '请输入取消时间',
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
        $this->addElement('text', 'cancel_cause', array(
            'label'         =>  '取消原因',
            'placeholder'   =>  '请输入取消原因',
            'class'         =>  'form-control szkj-form-control',
            'colspan'       =>  '9-9-12-12',
            'required'      =>  false,
            'filters'       =>  array('StringTrim'),
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

