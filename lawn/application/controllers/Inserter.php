<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Inserter extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index(){
        error_reporting(E_ALL);
        $xtDataArray = array();
        for($i = 1; $i < 100; $i++) {
            $xtDataArray = array();
        $xtDataArray['UserFirstName'] = "First_Name_" . $i;
        $xtDataArray['UserLastName'] = "Last_Name_" . $i;
        $xtDataArray['UserContactNumber'] = "9" . str_pad($i, 9, "0");
        $xtDataArray['UserPassword'] = "Password_" . $i;
        $xtDataArray['UserEmail'] = "xtUserEmail_" . $i . "@yopmail.com";
//        $xtDataArray['UserRole'] = "1";
            $xtBatchDataArray[] = $xtDataArray;
        }
        $this->db->insert_batch('users', $xtBatchDataArray); 
    }
}
