<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_InHospitalPayController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelnPay;
    private $modelUserInfo;
    private $modelOrder;
    private $modelWxUser;
    
    /**
     * 初始化
     */
    public function init()
    {
        require_once "Json.php";
        $this->modelnPay = new Application_Model_Pay();
        $this->modelUserInfo = new Application_Model_UserInfo();
        $this->modelOrder = new Application_Model_Order();
        $this->modelWxUser = new Application_Model_WxUser();
        
        $this->_helper->layout->setLayout('layout-wx');
    }

    /**
     * 默认页
     */
    public function indexAction()
    {
    }
     
    /**
     * 就诊卡充值
     */
    public function payAction()
    {
//         $openid = Application_Model_WxUser::getWeixinOpenid();
//         $openid = "1";
//         $user = $this->modelUserInfo->getSingle(array("openid"=>$openid));
//         if(!$user){
//             return $this->_redirect('/wx/user-info/warn');
//         }
//         $this->view->data = $this->modelUserInfo->getList("openid ='$openid' and hisid is not null");
    }
    
    /**
     * 支付成功
     */
    public function paymentSuccessAction(){
        $this->_helper->layout()->disableLayout();
    }
    
    /**
     * 支付失败
     */
    public function paymentLoseAction(){
        $this->_helper->layout()->disableLayout();
    }
    
    /**
     * 预交住院费用
     * @throws Exception
     */
    public function weixinPayAction() {
        require_once APPLICATION_PATH."/../library/Szkj/Wxpay/lib/WxPay.Api.php";
        require_once APPLICATION_PATH."/../library/Szkj/Wxpay/Basic/JsApiPay.php";
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        try {
            //1.用户数据及判断逻辑
            $price = $this->_request->getParam("price");
            $hisid = $this->_request->getParam("select_user");    //选择用户的hisid
            $name = $this->_request->getParam("name");
            if(!$price) throw new Exception("请选择金额",101);
            $openid = Application_Model_WxUser::getWeixinOpenid();
//             $openid = "oL46e0Zu_JWIlnT38hfMxG1APefg";
            $user = $this->modelWxUser->getSingle(array(
                'openid' => $openid
            ));
            if (!$user) {
                throw new Exception("您好，您暂未关注微信公众号，请前去关注！",102);
            }
            $user_id = $user->id;
            // 获取住院病人住院号码
            $url = "http://60.208.73.109:8000/api/call-view/get-patient-zy-brxx/hisid/$hisid";
            $res = file_get_contents($url);
            $res = json_decode($res);
            if(!$res) throw new Exception("您暂无住院信息,不能进行充值", 112);
            $zyhm = $res[0]->ZYHM;
//             $zyhm = "00131390";
            //2.支付处理
            /**
             * 微信支付开始，生成js参数
             */
            $tools = new Szkj_Wxpay_Basic_JsApiPay();
            //②、统一下单
            $input = new WxPayUnifiedOrder();
            $input->SetBody("住院缴费");  //商品标题
            $input->SetAttach("1");
            $order_num = "wxzy".WxPayConfig::MCHID.date("YmdHis").rand(10,99);//商户订单号
            $input->SetOut_trade_no($order_num);
            $input->SetTotal_fee($price*100);    //缴费金额
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetGoods_tag($zyhm);   //hisid
            $input->SetNotify_url("http://".$_SERVER['HTTP_HOST']."/wx/pay/weixin-callback");
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openid);
            $order = WxPayApi::unifiedOrder($input);
//             var_dump($order);exit;
            $jsApiParameters = $tools->GetJsApiParameters($order);
            $this->view->jsApiParameters = $jsApiParameters;
            /**
             * 微信支付结束
             */
            //3.本地订单插入
            /**
             * 微信系统订单表处理（商户）
             */
//             $order_num = "00617314153303173812206793626324452";
            $data = array(
                "user_id"           => $user_id,
                "hisid"             => $hisid,
                "zyhm"              => $zyhm,
                "type"              => 2,
                "name"              => $name,
                "openid"            => $openid,
                "fillTypeId"        => 3,   //充值类型为微信
                "transactionTypeId" => 1,    //交易类型为充值
                "jinE"              => $price,
                "order_num"         => $order_num,  //流水号
                "status"            => 0,
                "pay_method"        => "zyjf",
                "date"              => date("Y-m-d",time()),
                "fillDate"          => date("Y-m-d",time()),
            );
//             var_dump($data);exit; 
            $newid = $this->modelOrder->insert($data);
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$jsApiParameters);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 微信支付回调函数
     */
    public function weixinCallbackAction() {
        //调用微信回调，szkj_lib重写
        require_once APPLICATION_PATH . '/../library/Szkj/Wxpay/Notify.php';
        $notify = new Szkj_Wxpay_Notify();
        $notify->Handle(false);
    }
} 













