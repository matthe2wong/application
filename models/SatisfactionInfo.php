<?php
/**
 * 数据表模型-[模型名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Model_SatisfactionInfo extends Application_Model_Base
{
    /**
     * 对应数据表名称
     */
    protected $_name = 'zf_satisfaction_info';
    
    /**
     * 统计问题满意数量
     */
    public static function statistics($id,$sid,$question)
    {
        $model = new Application_Model_SatisfactionInfo();
        $array = array(
            "satisfaction_id"   =>$sid,
            "question_id"       =>$id,
            "question"          =>$question,
        );
        $count = $model->getCount($array);
        return $count;
    }
    
}

