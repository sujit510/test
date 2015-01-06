<?php

class Webservice_log_model extends CI_Model {

    var $ncTable = "webservice_logs";
    var $ncPrimary = "ID";

    public function get_all_logs($page) {
        $primary = $this->ncPrimary;
        $this->ncLoggerDb->where('Type', 'request');
        $ncDataResult = $this->ncLoggerDb->get($this->ncTable, 10, $page);
        $ncDataResultSet = $ncDataResult->result();
        $ncResultToBeCached = array();
        foreach ($ncDataResultSet as $ncResult) {
            $ncResultToBeCached[$ncResult->$primary] = $ncResult;
        }
        $ncListData = $ncResultToBeCached;
        return $ncListData;
    }
    
    function record_count(){
        return 25;
    }

}
