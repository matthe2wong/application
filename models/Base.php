<?php
/**
 * 数据表模型基类
 * @author liujin
 * @copyright  Copyright (c) 2014-2016 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 2.0
 */
class Application_Model_Base extends Zend_Db_Table_Abstract
{  
    /**
     * 导入Excel文件
     * @param string $excelFilePath
     * @return boolean
     */
    public function importExcel($excelFilePath)
    {
        require_once APPLICATION_PATH . '/../library/PHPOffice/PHPExcel/Classes/PHPExcel.php';
        require_once APPLICATION_PATH . '/../library/PHPOffice/PHPExcel/Classes/PHPExcel/IOFactory.php';
        require_once APPLICATION_PATH . '/../library/PHPOffice/PHPExcel/Classes/PHPExcel/Reader/Excel5.php';
        $objExcel = new PHPExcel();
        $excelReader = new PHPExcel_Reader_Excel2007();
        $objExcel = $excelReader->load($excelFilePath);
        $currentSheet = $objExcel->getSheet(0);
        $highestColumn = $currentSheet->getHighestColumn();
        $highestColumnName = (++$highestColumn);
        $highestRow = $currentSheet->getHighestRow();
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        try {
            $db->beginTransaction();
            // 1. 从第1列获得字段名称
            $row = 1;
            $columnNames = array();
            for ($column = 'A'; $column != $highestColumnName; $column ++) {
                $coordinate = $column . $row;
                $cellValue = $currentSheet->getCell($coordinate)->getValue();
                $items = explode(' ', $cellValue);  // 根据空格，得到字段名称
                if (count($items) == 2) {
                    $columnNames[$column] = $items[1];
                }
            }
            // 2. 从第2行开始逐行导入数据
            for ($row = 2; $row <= $highestRow; $row++) {
                $dataArray = array();
                for ($column = 'A'; $column != $highestColumnName; $column ++) {
                    $coordinate = $column . $row;
                    $cellValue = $currentSheet->getCell($coordinate)->getValue();
                    $dataArray[$columnNames[$column]] = $cellValue;
                }
                $newid = $this->insert($dataArray);
            }
            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
    
    /**
     * 处理Zend_Form表单，并返回表单数据数组
     * @param Zend_Form $form
     */
    protected function processForm($form)
    {
        // 1. 文件上传元素处理
        $filesInfo = array();
        foreach ($form->getElements() as $element) {
            if ($element->getType() == 'Zend_Form_Element_File') {
                $elementName = $element->getName();
                if (isset($_FILES[$elementName])) {
                    $originFileName = $_FILES[$elementName]['name'];
                    if ($originFileName == "") {
                        $filesInfo[$elementName] = null;
                        continue;
                    } else {
                        // 循环检查文件是否存在，若存在，则在文件名前面加1进行重命名
                        $dbSavePath = $element->getAttrib('relative_dir').'/'.$originFileName;
                        $absolutePath = APPLICATION_PATH.'/../public'.$dbSavePath;
                        while (is_file($absolutePath)) {
                            $originFileName = '1'.$originFileName;
                            $dbSavePath = $element->getAttrib('relative_dir').'/'.$originFileName;
                            $absolutePath = APPLICATION_PATH.'/../public'.$dbSavePath;
                        }
                        $element->addFilter("Rename",
                            array('target' => $originFileName, 'overwrite' => true));
                        $filesInfo[$elementName] = $dbSavePath;
                    }
                } else {
                    
                }
            }
        }
        // 2. 处理表单数据
        $formData = $form->getValues();
        if ($filesInfo): foreach ($filesInfo as $elementName=>$dbSavePath) {
            if ($dbSavePath == null) {
                unset($formData[$elementName]);
            } else {
                $formData[$elementName] = $dbSavePath;
                if (Szkj_Helper_Thumb::isImageFile($dbSavePath)) {
                    Szkj_Helper_Thumb::generateAllThumbs(APPLICATION_PATH.'/../public'.$dbSavePath);
                }
            }
        } endif;
        
        return $formData;
    }
    
    /**
     * 直接执行SQL命令
     * @param string $sql
     * @param string $quoteValues
     */
    public function rawExecute($sql, $quoteValues=null)
    {
        $db = $this->getAdapter();
        $sql = $db->quoteInto(
            $sql,
            $quoteValues
        );
        $result = $db->query($sql);
    }
    
    /**
     * 直接查询
     * @param string $sql
     * @param mixed $quoteValues
     */
    public function rawQuery($sql, $quoteValues=null)
    {
        $db = $this->getAdapter();
        $sql = $db->quoteInto(
            $sql,
            $quoteValues
        );
        $result = $db->query($sql);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows;
    }
    
    /**
     * 是否存在符合条件的记录
     * @param string|array $where
     * @return boolean
     */
    public function ifExist($where)
    {
        $single = $this->getSingle($where);
        return (null != $single);
    }
    
    /**
     * 统计数量
     * @param mixed $where
     */
    public function getCount($where = array())
    {
        return $this->getSingle($where, 'COUNT(*) AS countnum')->countnum;
    }
    
    /**
     * 获得最大值
     * @param string $fieldName
     * @param mixed $where
     */
	public function getMax($fieldName, $where = array())
	{
		return $this->getSingle($where, "max($fieldName) as max")->max;
	}
	
	/**
	 * 获得最小值
	 * @param string $fieldName
	 * @param mixed $where
	 */
	public function getMin($fieldName, $where = array())
	{
	    return $this->getSingle($where, "max($fieldName) as min")->min;
	}
	
	/**
	 * 获得单条数据
	 * @param mixed $where
	 * @param string $fileds
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL>
	 */
	public function getSingle($where = array(), $fileds='*', $order=null)
	{
		$select = $this->select();
		
		$select->from($this->_name, $fileds);
		
		if ( is_string($where) ){
			$select->where($where);
		}
		if ( is_array($where) && count($where) > 0 ) {
			foreach ($where as $key=>$value){
				$select->where($key.'=?', $value);
			}
		}
		if ( $order ) {
		    $select->order($order);
		}
		
		$result = $this->fetchRow($select);
		return $result;
	}
	
	/**
	 * 获得数据列表
	 * @param mixed $where
	 * @param mixed $order
	 * @param string $limit
	 * @param string $fields
	 * @param string $group
	 * @param string $like
	 * @param boolean $paginator
	 * @param array $joinParams
	 *     示例如下
	 *     array(
                array(
                    'tableName' => 'zf_category',
                    'relationship' => 'zf_article.category_id=zf_category.id',
                    'fields' => 'zf_category.title as category'
                ),
                array(
                    'tableName' => '',
                    'relationship' => '',
                    'fields' => ''
                ),
                ...
            )
	 * @return Zend_Paginator_Adapter_DbTableSelect|NULL
	 */
	public function getList($where = array(), $order=null, $limit=null, $fields=null, $group=null, $like=null, $paginator=false, $joinParams=array())
	{
		$select = $this->select();
		if ( is_string($where) ){
			$select->where($where);
		}
		if ( is_array($where) && count($where) > 0 ) {
			foreach ($where as $key=>$value){
				$select->where($key.'=?', $value);
			}
		}
		if ( $order ) {
			$select->order($order);
		}
		if ( $limit ) {
			$select->limit($limit[1], $limit[0]);
		}
		if ( $fields ) {
			$select->from($this->_name, $fields);
		}
		if ( $group ) {
			$select->group($group);
		}
		if ( $like ) {
			foreach ($like as $a) {
				$select->where($a['key'], $a['value']);
			}
		}
		if ( is_array($joinParams) && count($joinParams) > 0 ) {
		    $select->setIntegrityCheck(false);
		    foreach ($joinParams as $single) {
		        $select->join($single['tableName'], $single['relationship'], $single['fields']);
		    }
		}
		if ($paginator == false){
			$result = $this->fetchAll($select);
		} else {
			$result = new Zend_Paginator_Adapter_DbTableSelect($select);
		}
		
		if ($result->count() > 0) {
			return $result;
		} else {
			return null;
		}
	}

	/**
	 * 更新数据
	 *
	 * @param int $id
	 * @param array $data
	 * @throws Zend_Exception
	 * @return Ambigous <mixed, multitype:>
	 */
	public function updateData($id, $data = array())
	{
		$row = $this->find($id)->current();
		if ($row) {
			if (count($data)>0) {
				foreach ($data as $key=>$value) {
					$row->$key = $value;
				}
				return $row->save();
			} else {
				throw new Zend_Exception('提交数据出错！');
			}
		} else {
			throw new Zend_Exception('更新数据出错，未找到该数据！');
		}
	}
	
	/**
	 * 删除数据
	 * @param is_numeric|array $where
	 * @throws Zend_Exception
	 */
	public function deleteData($where)
	{
		$row = null;
		if ( is_numeric($where) || is_string($where) ){
			$row = $this->find($where)->current();
		}
		if ( is_array($where) && count($where) > 0 ){
			$select = $this->select();
			foreach ($where as $key=>$value){
				$select->where($key.'=?', $value);
				$row = $this->fetchRow($select);
			}
		}
		if ($row) {
			$row->delete();
		} else {
			throw new Zend_Exception('删除数据出错，未找到该数据！');
		}
	}
	
	
}

