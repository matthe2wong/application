<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_NocardAppointmentController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */ 
    private $modelAppointment;
    private $modelAppointmentWk;
    private $modelSection;
    private $modelDepartmentIntro;
    private $modelUserInfo;
    private $modelCollect;
    private $modelCancelAppointment;
    /**
     * 初始化
     */ 
    public function init()
    {
        require_once "Json.php";
        $this->modelAppointment = new Application_Model_Appointment();
        $this->modelAppointmentWk = new Application_Model_AppointmentWk();
        $this->modelSection = new Application_Model_Section();
        $this->modelDepartmentIntro = new Application_Model_DepartmentIntro();
        $this->modelUserInfo = new Application_Model_UserInfo();
        $this->modelCollect = new Application_Model_Collect();
        
        $this->_helper->layout->setLayout('layout-wx');
    }
    
    public function testAction(){
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
        
    }
    
    /**
     * 预约挂号
     */
    public function yyghAction()
    {
        $ksdm = $this->_request->getParam('ksdm');
//         $sql = "select max(YSDM) as YSDM,YSXM,max(KSMC) as KSMC,max(KSDM) as KSDM from V_MS_YSYYLIST
//         where KSDM='$ksdm' and YSXM is not null GROUP BY YSXM ORDER BY 'GZRQ' ASC";
//         $data = Szkj_Helper_Oracle::fetch($sql);
        
        $model = new Application_Model_IpConfig();
        $ip = $model->getSingle(array("id"=>1));
        $url = "http://".$ip->ip."/api/call-view/yygh/ksdm/$ksdm";
        $data = file_get_contents($url);
        $data = zend_json::decode($data);
        $this->view->data = $data;
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
    
    /**
     * 预约挂号-我的收藏
     */
    public function yyghCollectAction()
    {
        $ksdm = $this->_request->getParam('ksdm');
        $ysdm = $this->_request->getParam('ysdm');
//         $sql = "select max(YSDM) as YSDM,YSXM,max(KSMC) as KSMC,max(KSDM) as KSDM from V_MS_YSYYLIST
//         where KSDM='$ksdm' and YSDM='$ysdm' GROUP BY YSXM ORDER BY 'GZRQ' ASC";
//         $data = Szkj_Helper_Oracle::fetch($sql);

        $ip = $this->modelIpConfig->getSingle(array("id"=>1));
        $url = "http://".$ip->ip."/api/call-view/yygh-collect/ksdm/$ksdm/ysdm/$ysdm";
        $data = file_get_contents($url);
        $data = zend_json::decode($data);
        $this->view->data = $data; 
    }
    
    /**
     * 预约挂号每天挂号信息列表
     */
    public function yyghListAction()
    {
        $openid = Application_Model_WxUser::getWeixinOpenid();
        $ksdm = $this->_request->getParam('ksdm');
        $ysdm = $this->_request->getParam('ysdm');
        $gzrq = $this->_request->getParam('gzrq');

        $ip = $this->modelIpConfig->getSingle(array("id"=>1));
        
        $url = "http://".$ip->ip."/api/call-view/get-ysyy-day-list/ysdm/$ysdm";
        $info = file_get_contents($url);
        $info = zend_json::decode($info);
        $gzrq = preg_replace('# #', '', $gzrq);
        $url2 = "http://".$ip->ip."/api/call-view/get-ysyy-day-list2/ysdm/$ysdm/ksdm/$ksdm/gzrq/$gzrq";
        $data = file_get_contents($url2);
        $data = zend_json::decode($data);
        
        //查询是否已收藏
        $this->view->count = $this->modelCollect->getCount(array("openid"=>$openid,"ysdm"=>$ysdm,"ksdm"=>$ksdm));
        
        $this->view->data = $data;
        $this->view->info = $info;
        $this->view->ksdm = $ksdm;
        $this->view->ysdm = $ysdm;
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
    }
    
    
    /**
     * 挂号成功
     */
    public function ghcgAction()
    {
        $id = $this->_request->getParam('id');
        $flag = $this->_request->getParam('flag');
        if($flag == 1){ //有卡预约
            $data = $this->modelAppointment->getSingle(array("id"=>$id));
        }else if($flag == 2){ //$flag=2 无卡预约
            $data = $this->modelAppointmentWk->getSingle(array("id"=>$id));
        }else{      // $flag=3 无卡预约  已占号但未关联brid
            $data = $this->modelAppointmentWk->getSingle(array("id"=>$id));
        }
        $this->view->UserInfo = $this->modelUserInfo->getSingle(array("id"=>$data->user_id));
        $this->view->data = $data;
        $this->view->id = $id;
        $this->view->flag = $flag;
    }
    
    /**
     * 挂号取消
     */
    public function ghqxAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelCancelAppointment->getSingle(array("id"=>$id));
    }
    
    
    /**
     * 诊区列表
     */
    public function sectionAction()
    {
        $this->view->data = $this->modelSection->getList();
    }
    
    /**
     * 诊区列表
     */
    public function nsectionAction()
    {
    }
    
    /**
     * 二维数据去重
     * @param unknown $array
     * @param unknown $key
     * @return array
     */
    public function assoc_unique($array, $key)
    {
        $rAr=array();
        $data = array();
        for($i=0;$i<count($array);$i++)
        {
            if(!isset($rAr[$array[$i][$key]]))
            {
                $rAr[$array[$i][$key]]=$array[$i];
            }
        }
        $data = array_values($rAr);
        return $data;
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
    
    function getWeek($unixTime){
        $unixTime = is_numeric($unixTime) ? $unixTime : time();
        $weekarray = array('日','一','二','三','四','五','六');
        return $weekarray[date('w',$unixTime)];
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














