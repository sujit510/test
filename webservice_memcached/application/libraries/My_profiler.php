<?php
class MY_Profiler extends CI_Profiler {
    public function run()
    {
        $output = parent::run();
        $CI = &get_instance();
        // log output here, and optionally return it if you do want it to display
        $ncLoggerDb = $CI->load->database('logger_db', TRUE);
        $ncLoggerDb->insert("profiler", array("DateTime" => date("Y-m-d H:i:s"), "ProfilerData" => $output));
        if(isset($CI->config->config['show_profiler_output']) && $CI->config->config['show_profiler_output'])
            return $output;
    }
}
