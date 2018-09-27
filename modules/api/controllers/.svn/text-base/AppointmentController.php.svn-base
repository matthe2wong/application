<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_AppointmentController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelAppointment;
    private $modelSection;
    
    /**
     * 初始化
     */
    public function init()
    {
        $this->modelAppointment = new Application_Model_Appointment();
        $this->modelSection = new Application_Model_Section();
    }

    /**
     * 在线预约提交
     */
    public function subOnlineAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        try {
            $data["relation"] = $this->_request->getParam('relation');
            $data["name"] = $this->_request->getParam('name');
            $data["card_no"] = $this->_request->getParam('card_no');
            $data["phone"] = $this->_request->getParam('phone');
            $data["is_patient_card"] = $this->_request->getParam('is_patient_card');
            $data["patient_card"] = $this->_request->getParam('patient_card');
            $data["date"] = date("Y-m-d H:i:s",time());
            $data["openid"] = "";
            if($data["openid"]){
                //             $user = $t
            }
            $newid = $this->modelAppointment->insert($data);    
            if($newid){
                //调接口，入人民医院数据库
                
            }
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        
        echo Zend_Json::encode($result);
    }
    
    /**
     * 获得诊区
     */
    public function sectionAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        try {
            $sid = $this->_request->getParam('sid');
            $url = "http://188.188.30.122/Api/Zizhu/getDeptCate/sid/".$sid;
            $data = file_get_contents($url);
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        
        echo Zend_Json::encode($result);
    }
    
    /**
     * 获得科室二级列表
     */
    public function sectionSecondAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        try {
            $sid = $this->_request->getParam('sid');
            $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDeptCate/sid/$sid");
            $json = json_decode($json);
            if($json->error_code != 0) throw new Exception("暂无科室", 100);
            if($json->data){
                $val = array();
                foreach ($json->data as $d){
                   $val["dept_id"] = $d->dept_id;
                   $val["dept_name"] = $d->dept_name;
                   array_push($data, $val);
                }
            }
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 获得科室三级列表
     * 2.1.2.获取诊区可预约科室列表
     */
    public function sectionThirdAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        try {
            $dept_id = $this->_request->getParam('deptid');
            $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDepts/deptid/$dept_id");
            $json = json_decode($json);
            if($json->error_code != 0) throw new Exception("暂无科室", 100);
            if($json->data){
                $val = array();
                foreach ($json->data as $d){
                    $val["pid"] = $d->pid;
                    $val["subject"] = $d->subject;
                    $val["orgid"] = $d->orgid;
                    $val["dept_id"] = $d->dept_id;
                    array_push($data, $val);
                }
            }
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    
    /**
     * 获取当日预约科室的医生排班列表
     */
    public function getDoctorByTimeAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        try {
            $pid = $this->_request->getParam('pid');
            $date = $this->_request->getParam('date');
            $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDeptDuties/pid/$pid/date/$date");
            $json = json_decode($json);
//             var_dump($json);exit;
            if($json->error_code != 0) throw new Exception($json->error_text, 100);
            if($json->data){
                foreach ($json->data as $d){
                    $val = array();
                    $val["duty_id"] = $d->duty_id;
                    $val["duty_mae"] = $d->duty_mae;
                    $val["doctor_id"] = $d->doctor_id;
                    $val["doctor_code"] = $d->doctor_code;
                    $val["doctor_name"] = $d->doctor_name;
                    $val["profession"] = $d->profession;
                    $val["diseases"] = $d->diseases;
                    $val["status"] = $d->status;
                    $val["clinic_price"] = $d->clinic_price;
                    $val["duty_vnum"] = $d->duty_vnum;
                    $val["expert_flag"] = $d->expert_flag;
                    $val["doctor_sesstype"] = $d->doctor_sesstype;
                    $val["doctor_sesstypecode"] = $d->doctor_sesstypecode;
                    $val["triage_place"] = $d->triage_place;
                    $val["duty_place"] = $d->duty_place;
                    if(@$data[$d->doctor_id]){
                        $data[$d->doctor_id]["duty_id2"] = $d->duty_id;
                        $data[$d->doctor_id]["duty_vnum2"] = $d->duty_vnum;
                    }else{
                        $data[$d->doctor_id] = $val;
                    }
                }
            } 
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    
    /**
     * 根据日期获取医生可预约时间点
     */
    public function getTimesByDoctorAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        $val = array();
        $arr = array();
        $da = array();
        try {
            $pid = $this->_request->getParam('pid');
            $date = $this->_request->getParam('date');
            $doctor_id = $this->_request->getParam('doctor_id');
            $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDeptDuties/pid/$pid/date/$date");
            $json = json_decode($json);
            if($json->error_code == 0){
                foreach ($json->data as $d){
                    $val["duty_id"] = $d->duty_id;
                    $val["duty_mae"] = $d->duty_mae;
                    $val["doctor_id"] = $d->doctor_id;
                    $val["doctor_code"] = $d->doctor_code;
                    $val["doctor_name"] = $d->doctor_name;
                    $val["profession"] = $d->profession;
                    $val["diseases"] = $d->diseases;
                    $val["clinic_price"] = $d->clinic_price;
                    $val["duty_vnum"] = $d->duty_vnum;
                    if($val["doctor_id"] == $doctor_id){
                        array_push($arr, $val);
                    }      
                }
                // 遍历该医生排版id  获取预约时间点
                foreach ($arr as $a){
                    $info = file_get_contents("http://188.188.30.122/Api/Wechat/getDutyTns/duty_id/".$a['duty_id']);
                    $info = json_decode($info);
                    if($info->error_code == 0){
                        foreach ($info->data as $v){
                            $tn1 = substr($v->tn,-2,2);
                            $da = array(
                                "duty_mae"  =>  $a["duty_mae"] == 1 ? "上午":"下午",
                                "tn"        => substr($v->tn,0,2).":".$tn1
                            );
                            array_push($data, $da);
                        }
                    }
                }
           }
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data );
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 2.1.5.获取医生排班下可预约时间点
     */
    public function getDutyTnsAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        $val = array();
        try {
            $duty_id = $this->_request->getParam('duty_id');
            $duty_id2 = $this->_request->getParam('duty_id2');
            $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDutyTns/duty_id/$duty_id");
            $json = json_decode($json);
            
//             if($json->error_code != 0) throw new Exception($json->error_text, 100);
            if($json->error_code == 0){
                foreach ($json->data as $d){
                    $tn1 = substr($d->tn,-2,2);
                    $val = array(
                        "duty_mae"  =>  "上午",
                        "tn"        => substr($d->tn,0,2).":".$tn1
                    );
                    array_push($data, $val);
                }
            }
            
            //判断该医生下午是否存在时间点
            if($duty_id2){
                $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDutyTns/duty_id/$duty_id2");
                $json = json_decode($json);
//                 if($json->error_code != 0) throw new Exception($json->error_text, 100);
                if($json->error_code == 0){
                    foreach ($json->data as $d){
                        $tn1 = substr($d->tn,-2,2);
                        $val = array(
                            "duty_mae"  =>  "下午",
                             "tn"        => substr($d->tn,0,2).":".$tn1
                        );
                        array_push($data, $val);
                    }
                }
            }
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 2.1.5.获取医生排班下可预约时间点
     */
    public function getDutyTnsAjax2Action()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        $val = array();
        try {
            $duty1 = $this->_request->getParam('duty1');
            $duty2 = $this->_request->getParam('duty2');
            
            if($duty1){     //判断该医生上午是否存在时间点
                $duty_id = substr($duty1,0,strrpos($duty1,','));
                $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDutyTns/duty_id/$duty_id");
                $json = json_decode($json);
                if($json->error_code == 0){
                    foreach ($json->data as $d){
                        $tn1 = substr($d->tn,-2,2);
                        $val = array(
                            "duty_mae"  =>  "上午",
                            "tn"        => substr($d->tn,0,2).":".$tn1
                        );
                        array_push($data, $val);
                    }
                }
            }
    
            //判断该医生下午是否存在时间点
            if($duty2){
                $duty_id2 = substr($duty2,0,strrpos($duty2,','));
                $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDutyTns/duty_id/$duty_id2");
                $json = json_decode($json);
                //                 if($json->error_code != 0) throw new Exception($json->error_text, 100);
                if($json->error_code == 0){
                    foreach ($json->data as $d){
                        $tn1 = substr($d->tn,-2,2);
                        $val = array(
                            "duty_mae"  =>  "下午",
                            "tn"        => substr($d->tn,0,2).":".$tn1
                        );
                        array_push($data, $val);
                    }
                }
            }
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 2.1.3.获取可预约科室的预约日期
     */
    public function getDeptDutyDateAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        $val = array();
        try {
            $pid = $this->_request->getParam('pid');
            $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDeptDutydate/pid/$pid");
            $json = json_decode($json);
            if($json->error_code == 0){
                if($json->data){
                    foreach ($json->data as $d){
//                         $val["duty_date"] = $d->duty_date;
                        array_push($data, $d->duty_date);
                    }
                } 
                $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
            }else{
                $result = array('code' => 201, 'msg' => '无排班信息');
            } 
//             var_dump($result);exit;
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    
    /**
     * 按科室获取医生信息
     */
    public function getDeptDoctorsAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        $val = array();
        try {
            $pid = $this->_request->getParam('pid');
            $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDeptDoctors/pid/$pid");
            $json = json_decode($json);
           
            if($json->error_code == 0){
                if($json->data){
                    foreach ($json->data as $d){
                        $val["doctor_id"] = $d->doctor_id;
                        $val["doctor_code"] = $d->doctor_code;
                        $val["subject"] = $d->subject;
                        $val["orgname"] = $d->orgname;
                        $val["orgaddr"] = $d->orgaddr;
                        $val["profession"] = $d->profession;
                        $val["diseases"] = $d->diseases;
                        $val["thumb"] = $d->thumb;
                        $val["introduce"] = $d->introduce;
                        $val["dept_id"] = $d->dept_id;
                        $val["pid"] = $d->pid;
                        array_push($data, $val);
                    }
                    $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
                }else{
                    $result = array('code' => 201, 'msg' => '无排班信息');
                }
            }else{
                $result = array('code' => 202, 'msg' => '请求失败');
            }
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    
    /**
     * 获取医生的七天排班
     */
    public function getNewDoctorDutiesAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        $val = array();
        $duty = array();
        $child = array();
        $dateArr = array();
        $res = array();
        try {
            $pid = $this->_request->getParam('pid');
            $doctor_id = $this->_request->getParam('doctor_id');
            //获取医生的七天排班（新增“当日排班”）
            $json = file_get_contents("http://188.188.30.122/Api/Wechat/getNewDoctorDuties/pid/$pid/doctor_id/$doctor_id");
            $json = json_decode($json);
            if($json->error_code == 0){
                
                $arr = $json->data;
                if($arr){
                    $val["doctor_id"] = $arr->doctor_id;
                    $val["doctor_code"] = $arr->doctor_code;
                    $val["doctor_name"] = $arr->doctor_name;
                    $val["org_name"] = $arr->org_name;
                    $val["profession"] = $arr->profession;
                    $val["diseases"] = $arr->diseases;
                    $val["thumb"] = $arr->thumb;
                    $val["clinic_price"] = substr($arr->clinic_price,0,strrpos($arr->clinic_price,'.'));
                    array_push($data, $val);
                    if($arr->duty){
                        foreach ($arr->duty as $k=>$d){
                            if (!array_key_exists($d->duty_date,$res)){
                                $dates = array("duty_id1"=>$d->duty_id.','.$d->duty_mae);
                            }else{
//                                 array_push($dates, array("duty_id2"=>$d->duty_id.''.$d->duty_mae));
                                $dates = array("duty_id1"=>$res[$d->duty_date]['duty_id1'],"duty_id2"=>$d->duty_id.','.$d->duty_mae);
                            }
                            $res[$d->duty_date] = $dates;
                            
//                             $dates = array("date" => $d->duty_date,"duty_id"=>$d->duty_id,"duty_mae"=>$d->duty_mae,);
//                             array_push($res, $dates);
                            // 日期去重
                            array_push($dateArr, $d->duty_date);
                            $dateArr = array_unique($dateArr);
                            $dateStr = implode("  ", $dateArr);
//                             $dateArr = array_unique($dateArr);
//                             $date = $d->duty_date;
//                             $json = file_get_contents("http://188.188.30.122/Api/Wechat/getDutyTns/duty_id/$d->duty_id");
//                             $json = json_decode($json);
//                             if($json->error_code !=0) throw new Exception($json->error_text, $json->error_code);
//                             foreach ($json->data as $da){
//                                 $tn1 = substr($da->tn,-2,2);
//                                 $da = array(
//                                     "duty_mae"  =>  $d->duty_mae == 1 ? "上午":"下午",
//                                     "tn"        => substr($da->tn,0,2).":".$tn1
//                                 );
//                                 array_push($child, $da);
//                             }
// //                             var_dump($duty);exit;
//                             $duty = array_merge($duty, $child);
                        }
                    }
                    $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data[0], 'duty'=>$duty ,'res'=>$res,"dataStr"=>$dateStr);
                }else{
                    $result = array('code' => 201, 'msg' => '无排班信息');
                }
            }else{
                $result = array('code' => 202, 'msg' => $json->error_text);
            }
//             var_dump($result);exit;
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
}













