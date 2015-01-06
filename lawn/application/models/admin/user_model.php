<?php

class User_model extends CI_Model {

    var $ncTable = "users";

    public function get_all_user($ncPage = "0", $ncPerPage) {
        //Get all users
        $ncUserListCacheKey = $this->ncListingCacheKey . "_pg_" . $ncPage . "_" . $ncPerPage;//exit($ncUserListCacheKey);
        $ncListData = $this->cache->memcached->get($ncUserListCacheKey);
        if (!$ncListData || (count($ncListData) < 1)) {
            $ncDataResult = $this->db->query("SELECT * FROM users LIMIT " . $ncPage . "," . $ncPerPage);
//            $ncDataResult = $this->db->query("CALL SP_SELECT_USERS('', '', 'LIMIT ". $ncPage . "," . $ncPerPage . "')");
//            $ncDataResult = $this->db->query("CALL SP_GET_ALL_ROWS('users', '', '', 'LIMIT 10,5')");
            $ncDataResultSet = $ncDataResult->result();
            $ncResultToBeCached = array();
            foreach ($ncDataResultSet as $ncResult) {
                $ncResultToBeCached[$ncResult->ID] = $ncResult;
                //User Role
                $ncUserRoleMapping = $this->cache->memcached->get($this->ncUserRoleMappingsCacheKey . "_" . $ncResult->ID);
                if ($ncUserRoleMapping)
                    $ncResult->ncUserRole = explode(",", $ncUserRoleMapping);
                else {
                    $ncThisUserRoleArr = $this->common_model->get_dropdown_array("user_role", "ID", "RoleID", "AND UserID = " . $ncResult->ID, FALSE);
                    if (count($ncThisUserRoleArr) > 0) {
//                        $this->cache->memcached->save($this->ncUserRoleMappingsCacheKey . "_" . $ncResult->ID, implode(",", $ncThisUserRoleArr), $this->config->config['memcached_expiration_time']);
                        $ncResult->ncUserRole = $ncThisUserRoleArr;
                    }
                }
//                $this->cache->memcached->save($this->ncAllUsersCacheKey . "_" . $ncResult->ID, $ncResult, $this->config->config['memcached_expiration_time']);
            }
            // Save into the cache
//            $this->cache->memcached->save($ncUserListCacheKey, implode(",", array_keys($ncResultToBeCached)), $this->config->config['memcached_expiration_time']);
            $ncListData = $ncResultToBeCached;
        } else {
            $ncUserIDArray = explode(",", $ncListData);
            $ncResultToBeCached = array();
            $this->benchmark->mark('code_start');
            foreach ($ncUserIDArray as $ncUserID) {
                $ncCachedUserData = $this->cache->memcached->get($this->ncAllUsersCacheKey . "_" . $ncUserID);
//                $ncCachedUserData = Memcache::getMulti(array($this->ncAllUsersCacheKey . "_" . $ncUserID));
                if ($ncCachedUserData)
                    $ncResultToBeCached[$ncUserID] = $ncCachedUserData;
            }
            $this->benchmark->mark('code_end');
            $ncListData = $ncResultToBeCached;
        }
        return $ncListData;
    }

    public function add_edit_user($id = "") {
        
        $ncDataArray = array();
        $ncDataArray['UserFirstName'] = $_POST['ncUserFirstName'];
        $ncDataArray['UserLastName'] = $_POST['ncUserLastName'];
        $ncDataArray['UserContactNumber'] = $_POST['ncUserContactNumber'];
        $ncDataArray['UserEmail'] = $_POST['ncUserEmail'];
        $ncPassString = base64_encode(date("YmdHis") . random_string());
        $ncDataArray['UserPassword'] = md5($_POST['ncUserPassword'] . $ncPassString);
        $ncDataArray['PassString'] = $ncPassString;

        $ncRoleDataArray = array();
        if ($id != "") {
            $ncDataArray['ModifiedOn'] = date("Y-m-d H:i:s");
            $this->db->update($this->ncTable, $ncDataArray, array("ID" => $id));
            //Update Role mapping
            $ncUserRoleMappingArray = $this->common_model->get_dropdown_array("user_role", "RoleID", "RoleID", "AND UserID=" . $id, FALSE);
            foreach($ncUserRoleMappingArray as $ncOlderRoleMapping) {
                if(!in_array($ncOlderRoleMapping, $_POST['ncUserRole'])) {
                    $this->db->delete("user_role", array("UserID" => $id, "RoleID" => $ncOlderRoleMapping));
                }
            }
            foreach($_POST['ncUserRole'] as $ncNewRoleMapping) {
                if(!in_array($ncNewRoleMapping, $ncUserRoleMappingArray)) {
                    $ncRoleDataArray[] = array("UserID" => $id, "RoleID" => $ncNewRoleMapping);
                }
            }
        } else {
            $ncDataArray['AddedOn'] = date("Y-m-d H:i:s");
            $this->db->insert($this->ncTable, $ncDataArray);
            $id = $this->db->insert_id();
            //Insert role mapping
            foreach ($_POST['ncUserRole'] as $ncRoleID) {
                $ncRoleDataArray[] = array('UserID' => $id, 'RoleID' => $ncRoleID);
            }
        }
        if(count($ncRoleDataArray) > 0)
                $this->db->insert_batch('user_role', $ncRoleDataArray);
        
        //Insert/Update Role mapping cache
//        $this->cache->memcached->save($this->ncUserRoleMappingsCacheKey. "_" . $id, implode(",", $_POST['ncUserRole']), $this->config->config['memcached_expiration_time']);
            
        //Insert/Update User cache accordingly.
        $ncUpdatedRow = $this->common_model->get_row($this->ncTable, "ID", $id);
        // Save into the cache
//        $this->cache->memcached->save($this->ncAllUsersCacheKey . "_" . $id, $ncUpdatedRow, $this->config->config['memcached_expiration_time']);
        return true;
    }
}
