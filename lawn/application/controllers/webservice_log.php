<?php

//if (!defined('BASEPATH'))
//    exit('No direct script access allowed');

class Webservice_log extends CI_Controller {

    var $xtListView = array();
    var $xtManageView = array();

    public function __construct() {
        parent::__construct();
        $this->load->model("webservice_log_model");
        $this->load->driver('cache');
        $this->output->enable_profiler($this->config->config['xt_enable_profiler']);
    }

    function list_webservice_log() {
        $this->xtListView['xtTableHeaders'] = array("Webservice", "Date Time");
        $this->xtListView['xtPageTitle'] = "List Webservice Logs";
        
        $config = array();
        $config["base_url"] = SITEURL . "/webservice_log/list_webservice_log";
        $config["uri_segment"] = 3;
        $config["total_rows"] = $this->webservice_log_model->record_count();
        $config["per_page"] = 10;
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $this->xtListView['xtPagination'] = $this->pagination->create_links();
                
        
        $this->xtListView['xtListData'] = $this->webservice_log_model->get_all_logs($page);
        $this->load->view("webservice_log/list_webservice_log", $this->xtListView);
    }
    
    function view_webservice_log() {
        $id = $_GET['id'];
        if($id == "")
            header("Location:" . SITEURL . "/webervice_log/list_webervice_log");
        $xtWebserviceLogRecord = $this->common_model->get_all_rows("xt_webservice_log", "xtID", $id, " OR xtRelatedID = " . $id);
        if(count($xtWebserviceLogRecord) <= 0)
            header("Location:" . SITEURL . "/webervice_log/list_webervice_log");
        $xtWebserviceLogRecord[0]->xtRequest = json_encode(json_decode(stripcslashes($xtWebserviceLogRecord[0]->xtRequest)), JSON_PRETTY_PRINT);
        $xtWebserviceLogRecord[1]->xtResponse = json_encode(json_decode(stripcslashes($xtWebserviceLogRecord[1]->xtResponse)), JSON_PRETTY_PRINT);
        $this->load->view("webservice_log/view_webservice_log", array('xtWebserviceLogRecord' => $xtWebserviceLogRecord));
    }

}
