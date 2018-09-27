<?php
/**
 * 数据表模型-[模型名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Model_PhysicianService extends Application_Model_Base
{
    /**
     * 对应数据表名称
     */
    protected $_name = 'zf_appointment_section';
    
    /**
     * 转换时间格式
     * 例：09-10月-16   2016-10-09
     * @param unknown $date
     */
    public static function convertTime($date){
        $time = "";
        if($date){
            $arr = explode("-", $date);
            $time = "20".$arr[2]."-".str_replace('月','',trim($arr[1]))."-".$arr[0];
        }
        $time=date('Y-m-d',strtotime($time));
        return $time;
    }
    
    /**
     * 4.12.插入病人预约信息Reservation
     * @param unknown $data
     * @return boolean
     */
    public static function reservationAction($data){
        $model = new Szkj_Helper_Oracle();
        $tns = "(DESCRIPTION =
                (ADDRESS_LIST =
                  (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.10.54)(PORT = 1521))
                )
                (CONNECT_DATA =
                  (SERVICE_NAME = hisdb)
                )
              )";
        $db_username = "ylz";
        $db_password = "ylz";
        try{
            $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
            if( !$conn ) {
                echo "Connection could not be established he.<br />";
                print_r($conn->errorInfo(), true);
                return false;
            }
            $bankId= iconv('UTF-8', 'GBK', $data['bankId']);
            $bankczId = iconv('UTF-8', 'GBK', $data['bankczId']);
            $brid = iconv('UTF-8', 'GBK', $data['patientCardId']);
            $RegiDept = iconv('UTF-8', 'GBK', $data['RegiDept']);
            $RegiIndoctor = iconv('UTF-8', 'GBK', $data['RegiIndoctor']);
            $RegiIndoZblb = iconv('UTF-8', 'GBK', $data['RegiIndoZblb']);
            $RegiZbxh = iconv('UTF-8', 'GBK', $data['RegiZbxh']);
            $RegiDate = iconv('UTF-8', 'GBK', $data['RegiDate']);
            $yyxh = "";
            $rtnvalue = "";
            $errmsg = "";
            $sql_sp = "BEGIN PORTAL_HIS.BSOFTINTERFACE.reservation(?,?,?,?,?,?,?,to_date(?,'YYYY-MM-DD'),?,?,?); END;";//Parse
            $temp = $conn->prepare($sql_sp);
            $temp->bindParam(1, $bankId);
            $temp->bindParam(2, $bankczId);
            $temp->bindParam(3, $brid);
            $temp->bindParam(4, $RegiDept);
            $temp->bindParam(5, $RegiIndoctor);
            $temp->bindParam(6, $RegiIndoZblb);
            $temp->bindParam(7, $RegiZbxh);
            $temp->bindParam(8, $RegiDate);
            $temp->bindParam(9, $yyxh,PDO::PARAM_INPUT_OUTPUT,6);
            $temp->bindParam(10, $rtnvalue,PDO::PARAM_INT,64);
            $temp->bindParam(11, $errmsg,PDO::PARAM_INPUT_OUTPUT,64);
            $temp->execute();
//             var_dump($conn->errorInfo());exit;
//             var_dump($rtnvalue,$rtnvalue,$errmsg);exit;
            return array("yyxh"=>$yyxh,"rtnvalue"=>$rtnvalue,"errmsg"=>$errmsg);
        }catch(PDOException $e){
            echo ($e->getMessage());
        }
    }
    /**
     * 4.12.无卡预约Reservation
     * @param unknown $data
     * @return boolean
     */
    public static function reservationbysfzhAction($data){
        $model = new Szkj_Helper_Oracle();
        $tns = "(DESCRIPTION =
                (ADDRESS_LIST =
                  (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.10.36)(PORT = 1521))
                )
                (CONNECT_DATA =
                  (SERVICE_NAME = orcltest)
                )
              )";
        $db_username = "ylz";
        $db_password = "ylz";
        try{
            $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
            if( !$conn ) {
                echo "Connection could not be established he.<br />";
                print_r($conn->errorInfo(), true);
                return false;
            }
            $bankczId= $data['bankczId'];
            $socialNo = $data['socialNo'];
            $paientName = $data['paientName'];
            $relationTel = $data['relationTel'];
            $RegiDept = $data['RegiDept'];
            $RegiIndoctor = $data['RegiIndoctor'];
            $RegiIndoZblb = $data['RegiIndoZblb'];
            $RegiZbxh = $data['RegiZbxh'];
            $RegiDate = $data['RegiDate'];
            $rtnvalue = "";
            $errmsg = "";
            $sql_sp = "BEGIN PORTAL_HIS.BSOFTINTERFACE.reservationbysfzh(?,?,?,?,?,?,?,?,to_date(?,'YYYY-MM-DD'),?,?); END;";//Parse
            $temp = $conn->prepare($sql_sp);
            
            $temp->bindParam(1, $bankczId);
            $temp->bindParam(2, $socialNo);
            $temp->bindParam(3, $paientName);
            $temp->bindParam(4, $relationTel);
            $temp->bindParam(5, $RegiDept);
            $temp->bindParam(6, $RegiIndoctor);
            $temp->bindParam(7, $RegiIndoZblb);
            $temp->bindParam(8, $RegiZbxh);
            $temp->bindParam(9, $RegiDate);
            $temp->bindParam(10, $rtnvalue,PDO::PARAM_INT,64);
            $temp->bindParam(11, $errmsg,PDO::PARAM_INPUT_OUTPUT,64);
            
            //             var_dump($temp);exit;
            $temp->execute();
//             var_dump($conn->errorInfo());
//             var_dump($rtnvalue,$rtnvalue,$errmsg);exit;
            return array("Result_CODE"=>$rtnvalue,"Error_Msg"=>$errmsg);
        }catch(PDOException $e){
            echo ($e->getMessage());
        }
    }
    /**
     * 4.12.取消预约 旧
     * @param unknown $data
     * @return boolean
     */
    public static function cancelReservation1Action($data){
        $model = new Szkj_Helper_Oracle();
        $tns = "(DESCRIPTION =
                (ADDRESS_LIST =
                  (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.10.54)(PORT = 1521))
                )
                (CONNECT_DATA =
                  (SERVICE_NAME = hisdb)
                )
              )";
        $db_username = "ylz";
        $db_password = "ylz";
        try{
            $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
            if( !$conn ) {
                echo "Connection could not be established he.<br />";
                print_r($conn->errorInfo(), true);
                return false;
            }
            $l_yyxh= (int)iconv('UTF-8', 'GBK', $data['l_yyxh']);
            $s_qxyy = iconv('UTF-8', 'GBK', $data['s_qxyy']);
            $l_yyxh = 19734;
            $s_qxyy = '医院原因';
            $res = "";
            $rtnValue = "";
            $errmsg = "";
            $sql_sp = "BEGIN 
                PORTAL_HIS.BSOFTINTERFACE.CancelYygh(?,?,?,?,?);
            END;";//Parse
            $temp = $conn->prepare($sql_sp);
//             $l_yyxh = 1234;
//             var_dump($l_yyxh);exit;
//             $temp->bindParam(1, $s_qxyy,PDO::PARAM_INT);
//             $temp->bindParam(2, $res,PDO::PARAM_INPUT_OUTPUT,64);
//             $temp->bindParam(3, $rtnValue,PDO::PARAM_INPUT_OUTPUT,64);
//             $temp->bindParam(4, $errmsg,PDO::PARAM_INPUT_OUTPUT,64);
            $temp->bindParam(1, $l_yyxh);
            $temp->bindParam(2, $s_qxyy);
            $temp->bindParam(3, $res, PDO::PARAM_LOB | PDO::PARAM_INPUT_OUTPUT, 10000);
            $temp->bindParam(4, $rtnValue,PDO::PARAM_INPUT_OUTPUT,64);
            $temp->bindParam(5, $errmsg,PDO::PARAM_INPUT_OUTPUT,64);
             
//             $temp->execute(); 
            var_dump($conn->errorInfo()); 
            var_dump($res,$rtnValue,$errmsg);
            exit;
            return array("yyxh"=>$res,"rtnvalue"=>$rtnValue,"errmsg"=>$errmsg);
        }catch(PDOException $e){
            echo ($e->getMessage());
        }
    }
    
    /**
     * 4.12.取消预约
     * @param unknown $data
     * @return boolean
     */
    public static function cancelReservationAction($data){
        $result = array();
        $conn=ocilogon("ylz","ylz","192.168.10.54/hisdb");
        if(!$conn){
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        
        $l_yyxh = (int)iconv('UTF-8', 'GBK', $data['l_yyxh']);
        $s_qxyy = iconv('UTF-8', 'GBK', $data['s_qxyy']);
        $curs = oci_new_cursor($conn);
        $stid = oci_parse($conn,"
        BEGIN 
          BSOFTINTERFACE.CancelYygh(:l_yyxh,:s_qxyy, :res, :rtnValue, :errmsg); 
        END;
        ");
        oci_bind_by_name($stid, ":l_yyxh", $l_yyxh);
        oci_bind_by_name($stid, ":s_qxyy", $s_qxyy);
        oci_bind_by_name($stid, ":res", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":rtnValue", $rtnValue, 64);
        oci_bind_by_name($stid, ":errmsg", $errmsg, 64);
        oci_execute($stid);
        oci_execute($curs);
//          while(($row = oci_fetch_array($curs))!=false){
//              var_dump($row);
             //echo $row['FIRST_NAME']."<br/>";         
//          }
        
        oci_free_statement($stid);
        oci_free_statement($curs);
        $result = array(
            "code"  => $rtnValue,
            "msg"   => $errmsg
        );
        oci_close($conn);
        return $result;
    }
    
    
    /**
     * 4.2.获取病人getBridbykh 
     * @param unknown $card
     * @param unknown $identity_card
     * @return boolean|string
     */
    public static function getBridbykh($identity_card,$type){
        $model = new Szkj_Helper_Oracle();
        $tns = "(DESCRIPTION =
                (ADDRESS_LIST =
                  (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.10.54)(PORT = 1521))
                )
                (CONNECT_DATA =
                  (SERVICE_NAME = hisdb)
                )
              )";
        $db_username = "ylz";
        $db_password = "ylz"; 
        try{
            $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
            if( !$conn ) {
                echo "Connection could not be established he.<br />";
                print_r($conn->errorInfo(), true);
                return false;
            }
            $brkh= $identity_card;
            $ll_brid = "";
            $sql_sp = "BEGIN PORTAL_HIS.BSOFTINTERFACE.getBridbykh(?,?,?); END;";//Parse
            $temp = $conn->prepare($sql_sp);
            
            $temp->bindParam(1, $brkh);
            $temp->bindParam(2, $type);
            $temp->bindParam(3, $ll_brid,PDO::PARAM_INT,64);
            $temp->execute();
            return $ll_brid;
        }catch(PDOException $e){
            echo ($e->getMessage());
        }
    }
    
    
    /**
     * 4.3.充值RechargeBybrid
     * @param unknown $data
     * @return boolean
     */
    public static function RechargeBybridAction($data){
        $model = new Szkj_Helper_Oracle();
        $tns = "(DESCRIPTION =
                (ADDRESS_LIST =
                  (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.10.36)(PORT = 1521))
                )
                (CONNECT_DATA =
                  (SERVICE_NAME = orcltest)
                )
              )";
        $db_username = "ylz";
        $db_password = "ylz";
        try{
            $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
            if( !$conn ) {
                echo "Connection could not be established he.<br />";
                print_r($conn->errorInfo(), true);
                return false;
            }
            $ls_bankId= "8888";
            $ls_bankczId = "8888";
            $ll_brid = $data['hisid'];
            $ll_fillTypeId = 3;
            $ll_jinE = $data['jinE'];
            $ldt_fillDate = $data['fillDate'];
            $ls_bankCardNo = $data['bankCardNo'];
            $ls_transactionTypeId = 1;
            $description = "";
            $ls_czgh = "8888";
            $ls_lsh = $data['order_num'];
            $qsrq  = $data['fillDate'];
            $if_TfError = 0;
            $errmsg = "";
            $yktje = "";
            $Pzhm = "";
            $returnvalues = "";
            $sql_sp = "BEGIN PORTAL_HIS.BSOFTINTERFACE.RechargeBybrid(?,?,?,?,?,to_date(?,'YYYY-MM-DD'),?,?,?,?,?,to_date(?,'YYYY-MM-DD'),?,?,?,?,?); END;";//Parse
            $temp = $conn->prepare($sql_sp);
            
            $temp->bindParam(1, $ls_bankId);
            $temp->bindParam(2, $ls_bankczId);
            $temp->bindParam(3, $ll_brid);
            $temp->bindParam(4, $ll_fillTypeId);
            $temp->bindParam(5, $ll_jinE);
            $temp->bindParam(6, $ldt_fillDate);
            $temp->bindParam(7, $ls_bankCardNo);
            $temp->bindParam(8, $ls_transactionTypeId);
            $temp->bindParam(9, $description );
            $temp->bindParam(10, $ls_czgh);
            $temp->bindParam(11, $ls_lsh);
            $temp->bindParam(12, $qsrq);
            $temp->bindParam(13, $if_TfError);
            $temp->bindParam(14, $errmsg,PDO::PARAM_INT,64);
            $temp->bindParam(15, $yktje,PDO::PARAM_INT,64);
            $temp->bindParam(16, $Pzhm,PDO::PARAM_INT,64);
            $temp->bindParam(17, $returnvalues,PDO::PARAM_INPUT_OUTPUT,64);
            
            //             var_dump($temp);exit;
            $temp->execute();
            var_dump($conn->errorInfo());
            var_dump($errmsg,$yktje,$Pzhm,$returnvalues);exit;
            return array("Result_CODE"=>$rtnvalue,"Error_Msg"=>$errmsg);
        }catch(PDOException $e){
            echo ($e->getMessage());
        }
    }
    
}

