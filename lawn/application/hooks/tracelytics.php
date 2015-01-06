<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Retrieve the CodeIgniter class & method used for this request and log it to TraceView.
class TraceViewHooks {
    public function post_controller() {
        $CI =& get_instance();
        $message = "";
        $fractions = explode(" ", microtime());
        $message .= date("Y-m-d H:i:s") . " == " . $fractions[0] . " == Leaving " . json_encode(array("Controller" => $CI->router->class, 
					   "Action" => $CI->router->method));
        $ncLoggerDb = $CI->load->database('logger_db', TRUE);
        $ncLoggerDb->insert("trace", array("DateTime" => date("Y-m-d H:i:s"), "TracedData" => $message));
    }
    
    public function post_controller_constructor() {
        $CI =& get_instance();
        $message = "";
        $fractions = explode(" ", microtime());
        $message .= date("Y-m-d H:i:s") . " == " . $fractions[0] . " == Post Constructor " . json_encode(array("Controller" => $CI->router->class, 
					   "Action" => $CI->router->method));
        $ncLoggerDb = $CI->load->database('logger_db', TRUE);
        $ncLoggerDb->insert("trace", array("DateTime" => date("Y-m-d H:i:s"), "TracedData" => $message));
    }
    
    public function pre_controller() {
        $CI =& get_instance();
        $message = "";
        $fractions = explode(" ", microtime());
        $message .= date("Y-m-d H:i:s") . " == " . $fractions[0] . " == Entering " . json_encode(array("Controller" => $CI->router->class, 
					   "Action" => $CI->router->method));
        
//        echo "<pre>";print_r($this);exit;
//$this->load->database();
//        $CI->db->insert("xt_trace", array("DateTime" => date("Y-m-d H:i:s"), "TracedData" => $message));
    }
}
?>