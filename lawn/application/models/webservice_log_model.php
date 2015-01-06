<?php

class Webservice_log_model extends CI_Model {

    var $xtTable = "xt_webservice_log";
    var $xtPrimary = "xtID";

    public function get_all_logs($page) {
        $primary = $this->xtPrimary;
        $this->db->where('xtType', 'request');
        $xtDataResult = $this->db->get($this->xtTable, 10, $page);
        $xtDataResultSet = $xtDataResult->result();
        $xtResultToBeCached = array();
        foreach ($xtDataResultSet as $xtResult) {
            $xtResultToBeCached[$xtResult->$primary] = $xtResult;
        }
        $xtListData = $xtResultToBeCached;
        return $xtListData;
    }
    
    function record_count(){
        return 25;
    }

}
