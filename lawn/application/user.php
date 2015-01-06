<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    var $ncListView = array();
    var $ncManageView = array();
    //Cache keys
    var $ncListingCacheKey = "ncListData";//Later make this dynamic as per order by, limit, search, etc. e.g. ncListData_limit10,5_orderasc_orderby_userid
    var $ncAllUsersCacheKey = "ncUsers";
    var $ncUserRoleMappingsCacheKey = "ncUserRoleMappings";
    var $ncAllRolesCacheKey = "ncAllRoles";

    public function __construct() {
        parent::__construct();
        $this->load->model("admin/user_model");
        $this->load->driver('cache');
    }

    public function index() {
        $this->list_user();
    }

    function list_user() {
        $this->ncListView['ncTableHeaders'] = array("User's Name", "Email", "Contact Number", "Role");
        $this->ncListView['ncPageTitle'] = "List Users";
        $ncRolesArray = $this->cache->memcached->get($this->ncAllRolesCacheKey);
        if(!$ncRolesArray) {
             $ncRolesArray = $this->common_model->get_dropdown_array("roles", "ID", "RoleName", "", FALSE);
//             $this->cache->memcached->save($this->ncAllRolesCacheKey, $ncRolesArray, $this->config->config['memcached_expiration_time']);
        }
        $this->ncListView['ncRolesArray'] = $ncRolesArray;
        
        //Pagination
        $ncConfig = array();
        $ncConfig["base_url"] = SITEADMINURL . "/user/list_user";
        $ncConfig["uri_segment"] = 4;
        $ncConfig["total_rows"] = $this->common_model->get_count("users", "1", "1");
        $ncConfig["per_page"] = 10;
        $ncPage = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($ncConfig);
        $this->ncListView['ncPagination'] = $this->pagination->create_links();
        
        $this->ncListView['ncListData'] = $this->user_model->get_all_user($ncPage, $ncConfig["per_page"]);
//        $this->benchmark->mark('code_end');
        if (isset($_GET['msg'])) {
            $ncMessage = $this->config->config[$_GET['msg']];
            $this->ncListView['ncMessage'] = sprintf($ncMessage, "User");
        }
//        echo "<pre>";print_r($this->ncListView['ncListData']);exit;
        $this->load->view("admin/user/list_user", $this->ncListView);
    }

    function manage_user() {
        $ncRolesArray = $this->cache->memcached->get($this->ncAllRolesCacheKey);
        if(!$ncRolesArray) {
             $ncRolesArray = $this->common_model->get_dropdown_array("roles", "ID", "RoleName", "", FALSE);
//             $this->cache->memcached->save($this->ncAllRolesCacheKey, $ncRolesArray, $this->config->config['memcached_expiration_time']);
        }
//        print_r($ncRolesArray);
        $this->ncManageView['ncRolesArray'] = $ncRolesArray;
        $id = "";
        if (isset($_GET['id'])) {
            $id = base64_decode($_GET['id']);
            if (!is_numeric($id))
                header("Location:" . SITEADMINURL . "/user/list_user");
            $ncRow = $this->common_model->get_row("users", "ID", $id);
            if (!$ncRow)
                header("Location:" . SITEADMINURL . "/user/list_user");
        }
        if (isset($_POST['ncPageAction'])) {
            $this->form_validation->set_message("required", "%s is required");
            $this->form_validation->set_message("valid_email", "%s should be a valid email");
            $this->form_validation->set_message("numeric", "%s should be numeric");
            $this->form_validation->set_message("exact_length", "%s should be 10-digit");
            if ($this->form_validation->run('register') == TRUE) {
                $this->user_model->add_edit_user($id);
                switch ($_POST['ncPageAction']) {
                    case "Add" : $ncRedirectURL = SITEADMINURL . "/user/list_user?msg=success_add";
                        break;
                    case "Edit" : $ncRedirectURL = SITEADMINURL . "/user/list_user?msg=success_edit";
                        break;
                }
                header("Location:" . $ncRedirectURL);
                exit;
            } else {
                $this->ncManageView['ncErrors'] = validation_errors();
            }
        }

        if (isset($_GET['id'])) {
            $this->ncManageView['ncUserFirstName'] = $ncRow->UserFirstName;
            $this->ncManageView['ncUserLastName'] = $ncRow->UserLastName;
            $this->ncManageView['ncUserContactNumber'] = $ncRow->UserContactNumber;
            //Get user role
            $ncUserRoleArray = $this->common_model->get_dropdown_array("user_role", "RoleID", "RoleID", " AND UserID=" . $id, FALSE);
            $this->ncManageView['ncUserRole'] = $ncUserRoleArray;//$ncRow->UserRole;
            $this->ncManageView['ncUserEmail'] = $ncRow->UserEmail;
            $this->ncManageView['ncUserPassword'] = ""; //$ncRow->ncUserFirstName;
            $this->ncManageView['ncUserConfirmPassword'] = ""; //$ncRow->ncUserFirstName;
            $this->ncManageView['ncPageAction'] = "Edit";
            $this->ncManageView['ncPageTitle'] = "Edit User";
            $this->ncManageView['ncFormAction'] = SITEADMINURL . "/user/manage_user?id=" . $_GET['id'];
        } else {
            $this->ncManageView['ncUserFirstName'] = "";
            $this->ncManageView['ncUserLastName'] = "";
            $this->ncManageView['ncUserContactNumber'] = "";
            $this->ncManageView['ncUserRole'] = "";
            $this->ncManageView['ncUserEmail'] = "";
            $this->ncManageView['ncUserPassword'] = "";
            $this->ncManageView['ncUserConfirmPassword'] = "";
            $this->ncManageView['ncPageAction'] = "Add";
            $this->ncManageView['ncPageTitle'] = "Add User";
            $this->ncManageView['ncFormAction'] = SITEADMINURL . "/user/manage_user";
        }
        if (isset($_POST['ncUserFirstName']))
            $this->ncManageView['ncUserFirstName'] = $_POST['ncUserFirstName'];
        if (isset($_POST['ncUserLastName']))
            $this->ncManageView['ncUserLastName'] = $_POST['ncUserLastName'];
        if (isset($_POST['ncUserContactNumber']))
            $this->ncManageView['ncUserContactNumber'] = $_POST['ncUserContactNumber'];
        if (isset($_POST['ncUserRole']))
            $this->ncManageView['ncUserRole'] = $_POST['ncUserRole'];
        if (isset($_POST['ncUserEmail']))
            $this->ncManageView['ncUserEmail'] = $_POST['ncUserEmail'];
        $this->load->view("admin/user/manage_user", $this->ncManageView);
    }

    function delete_user() {
        $id = "";
        if (!isset($_GET['id']))
            header("Location:" . SITEADMINURL . "/user/list_user");
        $id = base64_decode($_GET['id']);
        if (!is_numeric($id))
            header("Location:" . SITEADMINURL . "/user/list_user");
        $ncRow = $this->common_model->get_row("users", "ID", $id);
        if (!$ncRow)
            header("Location:" . SITEADMINURL . "/user/list_user");
        $this->db->delete("users", array("ID" => $id));
        //Update cache accordingly.
        if ($this->cache->memcached->get($this->ncAllUsersCacheKey . "_" . $id)) {
            $this->cache->memcached->delete($this->ncAllUsersCacheKey . "_" . $id);
        }
        header("Location:" . SITEADMINURL . "/user/list_user?msg=success_delete");
    }

    function nc_match_passwords() {
        $ncPassword = $_POST['ncUserPassword'];
        $ncConfirmPassword = $_POST['ncUserConfirmPassword'];
        if ($ncPassword == $ncConfirmPassword)
            return true;
        else {
            $this->form_validation->set_message('nc_match_passwords', 'Passwords do not match');
            return FALSE;
        }
    }

    function nc_unique_email() {
        $ncWhere = "";
        if (isset($_GET['id'])) {
            $ncWhere .= " AND ncUserID != " . base64_decode($_GET['id']);
        }
        $ncUserEmail = $_POST['ncUserEmail'];
        $ncRecordsWithSameEmail = $this->common_model->get_row("nc_user", "ncUserEmail", $ncUserEmail, $ncWhere);
        if ($ncRecordsWithSameEmail) {
            $this->form_validation->set_message('nc_unique_email', '%s should be unique.');
            return FALSE;
        }
        return true;
    }

}
