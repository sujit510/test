<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Webservice_log extends CI_Controller {

    var $ncListView = array();
    var $ncManageView = array();
    var $ncLoggerDb;

    public function __construct() {
        parent::__construct();
        $this->load->model("admin/webservice_log_model");
        $this->load->driver('cache');
        $this->output->enable_profiler($this->config->config['nc_enable_profiler']);
        $this->ncLoggerDb = $this->load->database('logger_db', TRUE);
    }

    function list_webservice_log() {
        $this->ncListView['ncTableHeaders'] = array("Webservice", "Date Time");
        $this->ncListView['ncPageTitle'] = "List Webservice Logs";
        
        $config = array();
        $config["base_url"] = SITEADMINURL . "/webservice_log/list_webservice_log";
        $config["uri_segment"] = 4;
        $config["total_rows"] = $this->webservice_log_model->record_count();
        $config["per_page"] = 10;
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        $this->ncListView['ncPagination'] = $this->pagination->create_links();
                
        
        $this->ncListView['ncListData'] = $this->webservice_log_model->get_all_logs($page);
        $this->load->view("admin/webservice_log/list_webservice_log", $this->ncListView);
    }
    
    function view_webservice_log() {
        $id = $_GET['id'];
        if($id == "")
            header("Location:" . SITEADMINURL . "/webervice_log/list_webervice_log");
        $ncWebserviceLogRecord = $this->common_model->get_all_rows("webservice_logs", "ID", $id, " OR RelatedID = " . $id, $this->ncLoggerDb);
        if(count($ncWebserviceLogRecord) <= 0)
            header("Location:" . SITEADMINURL . "/webervice_log/list_webervice_log");
        $ncWebserviceLogRecord[0]->Request = json_encode(json_decode(stripcslashes($ncWebserviceLogRecord[0]->Request)), JSON_PRETTY_PRINT);
        $ncWebserviceLogRecord[1]->Response = json_encode(json_decode(stripcslashes($ncWebserviceLogRecord[1]->Response)), JSON_PRETTY_PRINT);
        $this->load->view("admin/webservice_log/view_webservice_log", array('ncWebserviceLogRecord' => $ncWebserviceLogRecord));
    }

}
