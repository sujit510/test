<?php

class Webservice_model extends CI_Model {

    var $ncTable = "nc_user";
    var $ncRoleTable = "nc_user_role";

    public function validate($request) {
        if(!isset($request['ncFunction'])) {
            return array('ncRequestStatus' => '0', 'ncMessage' => 'Please provide function name');
        }
        if(!isset($request['ncParams'])) {
            return array('ncRequestStatus' => '0', 'ncMessage' => 'Please provide function params');
        }
        return array('ncRequestStatus' => '1', 'ncMessage' => 'validated succesfully');
    }
    public function test($request) {
        return array('ncRequestStatus' => '1', 'ncMessage' => 'success', 'ncBody' => $request);
    }
    
    public function login($request) {
       $params = $request['ncParams'];
       if(!isset($params['ncUserEmail']) || !isset($params['ncUserPassword']))
           return array('ncRequestStatus' => '1', 'ncMessage' => 'success', 'ncBody' => array('ncLoginStatus' => '0', 'ncMessage' => 'username and/or password is blank'));
       $ncUserRow = $this->common_model->get_row('users', 'UserEmail', $params['ncUserEmail']);
       if(!$ncUserRow || (md5($params['ncUserPassword'] . $ncUserRow->PassString) != $ncUserRow->UserPassword))
            return array('ncRequestStatus' => '1', 'ncMessage' => 'success', 'ncBody' => array('ncLoginStatus' => '0', 'ncMessage' => 'Invalid username OR password'));
       else {
           //Generate Auth Key.
           $ncAuthKey = base64_encode(random_string() . $ncUserRow->ID);
           $this->db->insert("user_authkey", array("UserID" => $ncUserRow->ID, "AuthKey" => $ncAuthKey, "CreatedOn" => date("Y-m-d H:i:s"), "IsAuthKeyActive" => '1'));
//           $this->db->update('nc_user', array('ncAuthKey' => $ncAuthKey), array('ncUserID' => $ncUserRow->ncUserID));
           return array('ncRequestStatus' => '1', 'ncRequestMessage' => 'success', 'ncBody' => array('ncLoginStatus' => '1', 'ncMessage' => 'login success', 'ncUserID' => $ncUserRow->ID, 'ncAuthKey' => $ncAuthKey, 'ncAllowLogin' => $ncUserRow->AllowLogin));
       }
    
    }
    
    public function logout($request) {
       $params = $request['ncParams'];
       $ncUserAuthKeyRow = $this->common_model->get_row('user_authkey', 'UserID', $params['ncUserID'], "AND AuthKey = '" . $params['ncAuthKey'] . "' AND IsAuthKeyActive = '1'");
       if(!$ncUserAuthKeyRow)
            return array('ncRequestStatus' => '1', 'ncMessage' => 'success', 'ncBody' => array('ncLogoutStatus' => '0', 'ncMessage' => 'Invalid auth key'));
       else {
           //Destroy Auth Key.
           $this->db->update('user_authkey', array('IsAuthKeyActive' => "0", "DestroyedOn" => date("Y-m-d H:i:s")), array('ID' => $ncUserAuthKeyRow->ID));
           return array('ncRequestStatus' => '1', 'ncRequestMessage' => 'success', 'ncBody' => array('ncLogoutStatus' => '1', 'ncMessage' => 'logout success'));
       }
    
    }
}
