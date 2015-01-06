<?php

class User_model extends CI_Model {

    var $xtTable = "xt_user";

    public function get_all_user() {
        $xtListData = $this->cache->memcached->get('xtListData');
        if ( !$xtListData || (count($xtListData) < 1))
        {
            $xtDataResult = $this->db->get('xt_user');
            $xtDataResultSet = $xtDataResult->result();
            $xtResultToBeCached = array();
            foreach($xtDataResultSet as $xtResult) {
                $xtResultToBeCached[$xtResult->xtUserID] = $xtResult;
            }
            // Save into the cache
            $this->cache->memcached->save('xtListData', $xtResultToBeCached, $this->config->config['memcached_expiration_time']);
            $xtListData = $xtResultToBeCached;
        }
        return $xtListData;
    }
        
    public function add_edit_user($id = ""){
        $xtDataArray = array();
        $xtDataArray['xtUserFirstName'] = $_POST['xtUserFirstName'];
        $xtDataArray['xtUserLastName'] = $_POST['xtUserLastName'];
        $xtDataArray['xtUserContactNumber'] = $_POST['xtUserContactNumber'];
        $xtDataArray['xtUserEmail'] = $_POST['xtUserEmail'];
        $xtPassString = base64_encode(date("YmdHis") . random_string());
        $xtDataArray['xtUserPassword'] = md5($_POST['xtUserPassword'] . $xtPassString);
        $xtDataArray['xtPassString'] = $xtPassString;
        $xtDataArray['xtUserRole'] = $_POST['xtUserRole'];
        
        if($id != "") {
            $xtDataArray['xtModifiedOn'] = date("Y-m-d H:i:s");
            $this->db->update($this->xtTable, $xtDataArray, array("xtUserID" => $id));
        } else {
            $xtDataArray['xtAddedOn'] = date("Y-m-d H:i:s");
            $this->db->insert($this->xtTable, $xtDataArray);
            $id = $this->db->insert_id();
        }
        //Insert/Update cache accordingly.
        $xtListData = $this->cache->memcached->get('xtListData');
        if ($xtListData && array_key_exists($id, $xtListData))
        {
            $xtUpdatedRow = $this->common_model->get_row($this->xtTable, "xtUserID", $id);
            $xtListData[$id] = $xtUpdatedRow;
            // Save into the cache
            $this->cache->memcached->save('xtListData', $xtListData, $this->config->config['memcached_expiration_time']);
        }
        return true;
    }

}
