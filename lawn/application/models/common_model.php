<?php

class Common_model extends CI_Model {

    function get_dropdown_array($ncTableName, $ncKey, $ncValue, $ncWhere = "", $ncWantSelect = true, $ncWantSort = true) {
        $ncQuery = sprintf("SELECT * FROM %s WHERE 1 %s ", $ncTableName, $ncWhere);
//        $ncQuery = sprintf("CALL get_dropdown_array('%s', '%s');", $ncTableName, " 1 " . $ncWhere);
        
        //$ncQuery = sprintf("CALL SP_GET_ALL_ROWS('%s', '%s', '%s', '%s');", $ncTableName, ' WHERE 1 ' .  $ncWhere, "", "");
        $ncQueryExecute = $this->db->query($ncQuery);
        $ncResult = $ncQueryExecute->result();
        $ncReturnData = array();
        foreach ($ncResult as $val) {
            $ncReturnData[$val->$ncKey] = $val->$ncValue;
        }
        if ($ncWantSelect)
            $ncReturnData[''] = '--Select--';
        if ($ncWantSort)
            asort($ncReturnData);
        return $ncReturnData;
    }

    function get_row($ncTableName, $ncColumn, $ncValue, $ncWhere = "") {
        $ncQuery = sprintf("SELECT * FROM %s WHERE 1 AND %s='%s' %s ", $ncTableName, $ncColumn, $ncValue, $ncWhere);
       // $ncQuery = sprintf("CALL SP_GET_ALL_ROWS('%s', '%s', '%s', '%s');", $ncTableName, ' WHERE `'. $ncColumn . '` = "'. $ncValue . '" AND 1 ' . mysql_real_escape_string($ncWhere), "", "");
        $ncQueryExecute = $this->db->query($ncQuery);
        $ncResult = $ncQueryExecute->result();
        if ($ncResult)
            return $ncResult[0];
        return FALSE;
    }

    function get_all_rows($ncTableName, $ncColumn, $ncValue, $ncWhere = "", $ncDynamicDB = FALSE) {
        $ncQuery = sprintf("SELECT * FROM %s WHERE 1 AND %s='%s' %s ", $ncTableName, $ncColumn, $ncValue, $ncWhere);
        //$ncQuery = sprintf("CALL SP_GET_ALL_ROWS('%s', '%s', '%s', '%s');", $ncTableName, ' WHERE `'. $ncColumn . '` = "'. $ncValue . '" AND 1 ' .  $ncWhere, "", "");
        if($ncDynamicDB) {
            $ncQueryExecute = $ncDynamicDB->query($ncQuery);
        } else {
            $ncQueryExecute = $this->db->query($ncQuery);
        }
        $ncResult = $ncQueryExecute->result();
        if ($ncResult)
            return $ncResult;
        return FALSE;
    }

    function get_count($ncTableName, $ncColumn, $ncValue, $ncWhere = "") {
        $ncQuery = sprintf("SELECT * FROM %s WHERE 1 AND %s='%s' %s ", $ncTableName, $ncColumn, $ncValue, $ncWhere);
       // $ncQuery = sprintf("CALL SP_GET_COUNT('%s', '%s');", $ncTableName, ' WHERE '. $ncColumn . ' = "'. $ncValue . '" AND 1 ' .  $ncWhere);
        $ncQueryExecute = $this->db->query($ncQuery);
        $ncResult = $ncQueryExecute->result();
        if ($ncResult)
            return $ncResult[0]->cnt;
        return 0;
    }
    
    function get_log_db(){
        
    }
}
