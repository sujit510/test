<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Webservice extends CI_Controller {

    var $ncListView = array();
    var $ncManageView = array();
    var $ncLoggerDb;

    public function __construct() {
        parent::__construct();
        $this->load->model("admin/webservice_model");
        $this->load->driver('cache');
        $this->ncLoggerDb = $this->load->database('logger_db', TRUE);
    }

    function index() {
        $json = file_get_contents('php://input');
        $logdataarray = json_decode($json, TRUE);
        $logid = $this->log('request', $logdataarray['ncFunction'], $json);
        
        $validate = $this->webservice_model->validate($logdataarray);
        if($validate['ncRequestStatus'] == '1')
            $response = $this->webservice_model->$logdataarray['ncFunction']($logdataarray);
        else {
            $validate['ncBody'] = "";
            $response = $validate;
        }
        $responseJson = json_encode($response);
        $this->log('response', $logdataarray['ncFunction'], $responseJson, $logid);
        header('Content-type: application/json');
        echo $responseJson;
    }
    
    function log($type, $function = null, $logdata, $id = '0'){
        $data = array();
        $logdataarray = json_decode($logdata, TRUE);
        $data['UserID'] = (isset($logdataarray['ncParams']['ncUserID'])) ? $logdataarray['ncParams']['ncUserID'] : "0";
        $data['AuthKey'] = (isset($logdataarray['ncParams']['ncAuthKey'])) ? $logdataarray['ncParams']['ncAuthKey'] : "";
        $data['Webservice'] = $function;
        $data['Type'] = $type;
        if($type == 'request') {
            $data['Request'] = $logdata;
            $data['Response'] = "";
        } else {
            $data['Request'] = "";
            $data['Response'] = $logdata;
        }
        $data['DateTime'] = date("Y-m-d H:i:s");
        $data['RelatedID'] = $id;
        $this->ncLoggerDb->insert("webservice_logs", $data);
        return $this->ncLoggerDb->insert_id();
    }

}
