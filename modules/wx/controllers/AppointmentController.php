<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_AppointmentController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelAppointment;
    private $modelSection;
    private $modelDepartmentIntro;
    private $modelCollect;
    private $modelUserInfo;

    /**
     * 初始化
     */ 
    public function init()
    {
        $this->modelAppointment = new Application_Model_Appointment();
        $this->modelSection = new Application_Model_Section();
        $this->modelDepartmentIntro = new Application_Model_DepartmentIntro();
        $this->modelCollect = new Application_Model_Collect();
        $this->modelUserInfo = new Application_Model_UserInfo();
        
        $this->_helper->layout->setLayout('layout-wx');
    }
    
    /**
     * 提示页
     */
    public function hintAction()
    {
    
    }

    /**
     * 在线预约
     */
    public function indexAction()
    {
        $sid = $this->_request->getParam('sid');
        $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDeptCate/sid/$sid");
        $data = json_decode($json);
        var_dump($data);exit;
    }
    
    /**
     * 分诊自测
     */
    public function fzzcAction()
    {
    
    }
    
    /**
     * 我的预约
     */
    public function myReservationAction()
    {
    
    }
    
    /**
     * 我的挂号
     */
    public function wdghAction()
    {
    
    }
    
    /**
     * 预约挂号
     */
    public function yyghAction()
    {
    
    }
    
    
    /**
     * 预约挂号 - 按日期
     */
    public function yyghDateAction()
    {
        $data = array();
        $pid = $this->_request->getParam('pid');
        $name = $this->_request->getParam('name');
        
        for($i=0;$i<8;$i++){
            $arr["day"] = date('d',strtotime(date('Y-m-d').'+'.$i.'day'));
            $arr["date"] = date('Y-m-d',strtotime(date('Y-m-d').'+'.$i.'day'));
            $arr["week"] = $this->getWeek(strtotime($arr["date"]));
            array_push($data, $arr);
        }
        $this->view->data = $data;
        $this->view->pid = $pid;
        $this->view->name = $name;
        
    }
    
    /**
     * 预约挂号 - 按医生
     */
    public function yyghDoctorAction()
    {
        $this->view->pid = $this->_request->getParam('pid');
        $this->view->name = $this->_request->getParam('name');
    }
    
    function getWeek($unixTime){
        $unixTime = is_numeric($unixTime) ? $unixTime : time();
        $weekarray = array('日','一','二','三','四','五','六');
        return $weekarray[date('w',$unixTime)];
    }
    
    /**
     * 预约挂号每天挂号信息列表
     */
    public function yyghListAction()
    {
        $this->view->duty_id = $this->_request->getParam('duty_id');
        $this->view->duty_id2 = $this->_request->getParam('duty_id2');
        $this->view->doctor_id = $this->_request->getParam('doctor_id');
        $this->view->pid = $this->_request->getParam('pid');
        $this->view->diseases = $this->_request->getParam('diseases');
        
        $clinic_price = $this->_request->getParam('clinic_price');
        $clinic_price = substr($clinic_price,0,strrpos($clinic_price,'.'));
        $this->view->section_name = $this->_request->getParam('section_name');
        $this->view->doctor_name = $this->_request->getParam('doctor_name');
        $this->view->profession = $this->_request->getParam('profession');
        $this->view->date = $this->_request->getParam('date');
        $this->view->clinic_price = $clinic_price;
        
        
        $data = array();
        for($i=0;$i<8;$i++){
            $arr["day"] = date('d',strtotime(date('Y-m-d').'+'.$i.'day'));
            $arr["date"] = date('Y-m-d',strtotime(date('Y-m-d').'+'.$i.'day'));
            $arr["week"] = $this->getWeek(strtotime($arr["date"]));
            array_push($data, $arr);
        }
        $this->view->data = $data;
        
    }
    
    /**
     * 预约挂号每天挂号信息列表
     */
    public function yyghListDoctorAction()
    {
        $openid = "1";
        $doctor_id = $this->_request->getParam('doctor_id');
        $pid = $this->_request->getParam('pid');
    
        //查询是否已收藏
        $this->view->count = $this->modelCollect->getCount(array("openid"=>$openid,"pid"=>$pid,"doctor_id"=>$doctor_id));
        
        $data = array();
        for($i=0;$i<8;$i++){
            $arr["day"] = date('d',strtotime(date('Y-m-d').'+'.$i.'day'));
            $arr["date"] = date('Y-m-d',strtotime(date('Y-m-d').'+'.$i.'day'));
            $arr["week"] = $this->getWeek(strtotime($arr["date"]));
            array_push($data, $arr);
        }
        $this->view->data = $data;
        $this->view->doctor_id = $doctor_id;
        $this->view->pid = $pid;
    }
    
    /**
     * 预约挂号每天挂号信息列表详情
     */
    public function yyghListViewAction()
    {
        $this->view->name = $this->_request->getParam('name');
        $this->view->section_name = $this->_request->getParam('section_name');
        $this->view->profession = $this->_request->getParam('profession');
        $this->view->tn = $this->_request->getParam('tn');
        $this->view->duty_mae = $this->_request->getParam('duty_mae');
        $this->view->price = $this->_request->getParam('price');
        $date = $this->_request->getParam('date');
        $this->view->week = $this->getweek2($date);
        $this->view->date = $date;
        
        $this->view->data = $this->modelUserInfo->getList();
    }
    
    /**
     * 我的预约/排队
     */
    public function yyListAction()
    {
    
    }
    
    /**
     * 待支付
     */
    public function dzfAction()
    {
    
    }
    
    /**
     * 挂号成功
     */
    public function ghcgAction()
    {
    
    }
    
    /**
     * 挂号取消
     */
    public function ghqxAction()
    {
    
    }
    
    
    
    /**
     * 取消挂号
     */
    public function qxghAction()
    {
    
    }

    /**
     * 添加就诊人
     */
    public function addAction()
    {
    
    }
    
    
    /**
     * 预约挂号
     */
    public function appointAction()
    {
    
    }
    
    
    /**
     * 诊区列表
     */
    public function sectionAction()
    {
        $this->view->data = $this->modelSection->getList();
    }
    
    /**
     * 2.1.3.获取可预约科室的预约日期
     */
    public function sectionTimeAction(){
        $pid = $this->_request->getParam('pid');
        $json = file_get_contents("http://188.188.30.122/Api/Zizhu/getDeptDutydate/pid/$pid");
        $data = json_decode($json);
        $this->view->data = $data;
    }
    
    
    /**
     * 详情页
     */
    public function detailAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelAppointment->getSingle(array("id"=>$id));
    
        $this->view->topData = $this->modelAppointment->getList(null,null,10);
    }
    
    public function getweek2($date){
        header("Content-type: text/html; charset=utf-8");
        //强制转换日期格式
        $date_str=date('Y-m-d',strtotime($date));
        //封装成数组
        $arr=explode("-", $date_str);
        //参数赋值
        //年
        $year=$arr[0];
        //月，输出2位整型，不够2位右对齐
        $month=sprintf('%02d',$arr[1]);
        //日，输出2位整型，不够2位右对齐
        $day=sprintf('%02d',$arr[2]);
        //时分秒默认赋值为0；
        $hour = $minute = $second = 0;
        //转换成时间戳
        $strap = mktime($hour,$minute,$second,$month,$day,$year);
        //获取数字型星期几
        $number_wk=date("w",$strap);
        //自定义星期数组
        $weekArr=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
        //获取数字对应的星期
        return $weekArr[$number_wk];
    }
    
}













