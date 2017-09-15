<?php

/* * 
 * 公共模型
 */

namespace Common\Model;
use Think\Model;

class CommonModel extends Model {
	
	public $attr_type_arr = array(
		'int'=>'int(10) NOT NULL DEFAULT 0',
		'varchar'=>'varchar(255) NULL',
		'text'=>'text NULL',
		'datetime'=>'datetime NULL',
		'date'=>'date NULL',
	);
	
    /**
     * 删除表
     */
    final public function drop_table($tablename) {
    	$tablename = sp_table_name($tablename);
        try {
        	$re = $this->query("DROP TABLE $tablename");
        } catch (\Exception $e) {
        	
        }
        return $re;
    }
	
    /**
     * 创建表
     */
    final public function create_table($tablename){
    	$tablename = sp_table_name($tablename);
        try {
        	$re = $this->query("CREATE TABLE $tablename (id  int NOT NULL AUTO_INCREMENT ,PRIMARY KEY (id))");
        } catch (\Exception $e) {
        	 
        }
        return $re;
    }
    
    
    /**
     * 读取全部表名
     */
    final public function list_tables() {
        $tables = array();
        $data = $this->query("SHOW TABLES");
        foreach ($data as $k => $v) {
            $tables[] = $v['tables_in_' . strtolower(C("DB_NAME"))];
        }
        return $tables;
    }

    /**
     * 检查表是否存在 
     * $table 不带表前缀
     */
    final public function table_exists($table) {
    	$tablename = sp_table_name($table);
        $tables = $this->list_tables();
        return in_array($tablename, $tables) ? true : false;
    }

    /**
     * 获取表字段 
     * $table 不带表前缀
     */
    final public function get_fields($table) {
        $fields = array();

    	$table = sp_table_name($table);
        $data = $this->query("SHOW COLUMNS FROM $table");
        foreach ($data as $v) {
            $fields[$v['field']] = $v['type'];
        }
        return $fields;
    }

    /**
     * 检查字段是否存在
     * $table 不带表前缀
     */
    final public function field_exists($table, $field) {
        $fields = $this->get_fields($table);
        return array_key_exists($field, $fields);
    }
    
    protected function _before_write(&$data) {
        
    }
	
    final public function alert_field($table,$field,$old_field = null,$type = null){
    	if(!($table&$field)){
    		return false;
    	}
    	$table = sp_table_name($table);
    	if($type){
    		$attr_type = $this->attr_type_arr[$type];
    	}
    	else{
    		$fields = $this->get_fields($table);
    		if($fields[$old_field]){
    			$attr_type = $fields[$old_field];
    		}
    		else{
    			$attr_type = $this->attr_type_arr['text'];
    		}
    	}
    	try {
    		if(!$old_field){
    			$re = $this->query("ALTER TABLE $table ADD COLUMN `$field` $attr_type");
    		}
    		else{
    			if($this->field_exists($table, $old_field)){
    				
    				$re = $this->query("ALTER TABLE $table CHANGE COLUMN `$old_field` `$field` $attr_type");
    			}
    			else{
    				$re = $this->query("ALTER TABLE $table ADD COLUMN `$field` $attr_type");
    			}
    		}
        } catch (\Exception $e) {
			//E($e->getMessage());
        }
        return true;
    }
    
    final public function delete_field($table,$field){
    	if(!($table&$field)){
    		return false;
    	}
    	$table = sp_table_name($table);
    	try {
    		$re = $this->query("ALTER TABLE $table DROP COLUMN $field");
    	} catch (\Exception $e) {
    			
    	}
    	return true;
    }
}

