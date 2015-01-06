<?php

class Webservice_model extends CI_Model {

    var $xtTable = "xt_user";
    var $xtRoleTable = "xt_user_role";

    public function validate($request) {
        if(!isset($request['xtFunction'])) {
            return array('xtRequestStatus' => '0', 'xtMessage' => 'Please provide function name');
        }
        if(!isset($request['xtParams'])) {
            return array('xtRequestStatus' => '0', 'xtMessage' => 'Please provide function params');
        }
        return array('xtRequestStatus' => '1', 'xtMessage' => 'validated succesfully');
    }
    public function test($request) {
        return array('xtRequestStatus' => '1', 'xtMessage' => 'success', 'xtBody' => $request);
    }
    
    public function login($request) {
       $params = $request['xtParams'];
       if(!isset($params['xtUserEmail']) || !isset($params['xtUserPassword']))
           return array('xtRequestStatus' => '1', 'xtMessage' => 'success', 'xtBody' => array('xtLoginStatus' => '0', 'xtMessage' => 'username and/or password is blank'));
       $userRow = $this->common_model->get_row('xt_user', 'xtUserEmail', $params['xtUserEmail']);
       if(!$userRow || (md5($params['xtUserPassword'] . $userRow->xtPassString) != $userRow->xtUserPassword))
            return array('xtRequestStatus' => '1', 'xtMessage' => 'success', 'xtBody' => array('xtLoginStatus' => '0', 'xtMessage' => 'Invalid username OR password'));
       else {
           //Generate Auth Key.
           $xtAuthKey = base64_encode(random_string() . $userRow->xtUserID);
           $this->db->update('xt_user', array('xtAuthKey' => $xtAuthKey), array('xtUserID' => $userRow->xtUserID));
           return array('xtRequestStatus' => '1', 'xtRequestMessage' => 'success', 'xtBody' => array('xtLoginStatus' => '1', 'xtMessage' => 'login success', 'xtUserID' => $userRow->xtUserID, 'xtAuthKey' => $xtAuthKey, 'xtAllowLogin' => $userRow->xtAllowLogin));
       }
    
    }
    
    public function logout($request) {
       $params = $request['xtParams'];
       $userRow = $this->common_model->get_row('xt_user', 'xtUserID', $params['xtUserID']);
       if(!$userRow || ($params['xtAuthKey'] != $userRow->xtAuthKey))
            return array('xtRequestStatus' => '1', 'xtMessage' => 'success', 'xtBody' => array('xtLogoutStatus' => '0', 'xtMessage' => 'Invalid auth key'));
       else {
           //Generate Auth Key.
           $this->db->update('xt_user', array('xtAuthKey' => ""), array('xtUserID' => $userRow->xtUserID));
           return array('xtRequestStatus' => '1', 'xtRequestMessage' => 'success', 'xtBody' => array('xtLogoutStatus' => '1', 'xtMessage' => 'logout success'));
       }
    
    }
}
