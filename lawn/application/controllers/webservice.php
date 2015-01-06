<?php

//if (!defined('BASEPATH'))
//    exit('No direct script access allowed');

class Webservice extends CI_Controller {

    var $xtListView = array();
    var $xtManageView = array();

    public function __construct() {
        parent::__construct();
        $this->load->model("webservice_model");
        $this->load->driver('cache');
    }

    function index() {
        $json = file_get_contents('php://input');
        $logdataarray = json_decode($json, TRUE);
        $logid = $this->log('request', $logdataarray['xtFunction'], $json);
        
        $validate = $this->webservice_model->validate($logdataarray);
        if($validate['xtRequestStatus'] == '1')
            $response = $this->webservice_model->$logdataarray['xtFunction']($logdataarray);
        else {
            $validate['xtBody'] = "";
            $response = $validate;
        }
        $responseJson = json_encode($response);
        $this->log('response', $logdataarray['xtFunction'], $responseJson, $logid);
        header('Content-type: application/json');
        echo $responseJson;
    }
    
    function log($type, $function = null, $logdata, $id = '0'){
        $data = array();
        $logdataarray = json_decode($logdata, TRUE);
        $data['xtWebservice'] = $function;
        $data['xtType'] = $type;
        if($type == 'request') {
            $data['xtRequest'] = $logdata;
            $data['xtResponse'] = "";
        } else {
            $data['xtRequest'] = "";
            $data['xtResponse'] = $logdata;
        }
        $data['xtDateTime'] = date("Y-m-d H:i:s");
        $data['xtRelatedID'] = $id;
        $this->db->insert("xt_webservice_log", $data);
        return $this->db->insert_id();
    }

}
