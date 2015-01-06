<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    var $xtListView = array();
    var $xtManageView = array();

    public function __construct() {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->driver('cache');
    }

    public function index() {
        $this->list_user();
    }

    function list_user() {
        $this->xtListView['xtTableHeaders'] = array("User's Name", "Email", "Contact Number", "Role");
        $this->xtListView['xtPageTitle'] = "List Users";
        $this->xtListView['xtRolesArray'] = $this->common_model->get_dropdown_array("xt_user_role", "xpUserRoleID", "xpUserRoleName");

        $this->xtListView['xtListData'] = $this->user_model->get_all_user();
        if (isset($_GET['msg'])) {
            $xtMessage = $this->config->config[$_GET['msg']];
            $this->xtListView['xtMessage'] = sprintf($xtMessage, "User");
        }
        $this->load->view("user/list_user", $this->xtListView);
    }

    function manage_user() {
        $this->xtManageView['xtRolesArray'] = $this->common_model->get_dropdown_array("xt_user_role", "xpUserRoleID", "xpUserRoleName");
        $id = "";
        if (isset($_GET['id'])) {
            $id = base64_decode($_GET['id']);
            if (!is_numeric($id))
                header("Location:" . SITEURL . "/user/list_user");
            $xtRow = $this->common_model->get_row("xt_user", "xtUserID", $id);
            if (!$xtRow)
                header("Location:" . SITEURL . "/user/list_user");
        }
        if (isset($_POST['xtPageAction'])) {
            $this->form_validation->set_message("required", "%s is required");
            $this->form_validation->set_message("valid_email", "%s should be a valid email");
            $this->form_validation->set_message("numeric", "%s should be numeric");
            $this->form_validation->set_message("exact_length", "%s should be 10-digit");
            if ($this->form_validation->run('register') == TRUE) {
                $this->user_model->add_edit_user($id);
                switch ($_POST['xtPageAction']) {
                    case "Add" : $xtRedirectURL = SITEURL . "/user/list_user?msg=success_add";
                        break;
                    case "Edit" : $xtRedirectURL = SITEURL . "/user/list_user?msg=success_edit";
                        break;
                }
                header("Location:" . $xtRedirectURL);
                exit;
            } else {
                $this->xtManageView['xtErrors'] = validation_errors();
            }
        }

        if (isset($_GET['id'])) {
            $this->xtManageView['xtUserFirstName'] = $xtRow->xtUserFirstName;
            $this->xtManageView['xtUserLastName'] = $xtRow->xtUserLastName;
            $this->xtManageView['xtUserContactNumber'] = $xtRow->xtUserContactNumber;
            $this->xtManageView['xtUserRole'] = $xtRow->xtUserRole;
            $this->xtManageView['xtUserEmail'] = $xtRow->xtUserEmail;
            $this->xtManageView['xtUserPassword'] = ""; //$xtRow->xtUserFirstName;
            $this->xtManageView['xtUserConfirmPassword'] = ""; //$xtRow->xtUserFirstName;
            $this->xtManageView['xtPageAction'] = "Edit";
            $this->xtManageView['xtPageTitle'] = "Edit User";
            $this->xtManageView['xtFormAction'] = SITEURL . "/user/manage_user?id=" . $_GET['id'];
        } else {
            $this->xtManageView['xtUserFirstName'] = "";
            $this->xtManageView['xtUserLastName'] = "";
            $this->xtManageView['xtUserContactNumber'] = "";
            $this->xtManageView['xtUserRole'] = "";
            $this->xtManageView['xtUserEmail'] = "";
            $this->xtManageView['xtUserPassword'] = "";
            $this->xtManageView['xtUserConfirmPassword'] = "";
            $this->xtManageView['xtPageAction'] = "Add";
            $this->xtManageView['xtPageTitle'] = "Add User";
            $this->xtManageView['xtFormAction'] = SITEURL . "/user/manage_user";
        }
        if (isset($_POST['xtUserFirstName']))
            $this->xtManageView['xtUserFirstName'] = $_POST['xtUserFirstName'];
        if (isset($_POST['xtUserLastName']))
            $this->xtManageView['xtUserLastName'] = $_POST['xtUserLastName'];
        if (isset($_POST['xtUserContactNumber']))
            $this->xtManageView['xtUserContactNumber'] = $_POST['xtUserContactNumber'];
        if (isset($_POST['xtUserRole']))
            $this->xtManageView['xtUserRole'] = $_POST['xtUserRole'];
        if (isset($_POST['xtUserEmail']))
            $this->xtManageView['xtUserEmail'] = $_POST['xtUserEmail'];
        $this->load->view("user/manage_user", $this->xtManageView);
    }

    function delete_user() {
        $id = "";
        if (!isset($_GET['id']))
            header("Location:" . SITEURL . "/user/list_user");
        $id = base64_decode($_GET['id']);
        if (!is_numeric($id))
            header("Location:" . SITEURL . "/user/list_user");
        $xtRow = $this->common_model->get_row("xt_user", "xtUserID", $id);
        if (!$xtRow)
            header("Location:" . SITEURL . "/user/list_user");
        $this->db->delete("xt_user", array("xtUserID" => $id));
        //Update cache accordingly.
        $xtListData = $this->cache->memcached->get('xtListData');
        if ($xtListData && array_key_exists($id, $xtListData)) {
            unset($xtListData[$id]);
            // Save into the cache
            $this->cache->memcached->save('xtListData', $xtListData, $this->config->config['memcached_expiration_time']);
        }
        header("Location:" . SITEURL . "/user/list_user?msg=success_delete");
    }

    function xt_match_passwords() {
        $xtPassword = $_POST['xtUserPassword'];
        $xtConfirmPassword = $_POST['xtUserConfirmPassword'];
        if ($xtPassword == $xtConfirmPassword)
            return true;
        else {
            $this->form_validation->set_message('xt_match_passwords', 'Passwords do not match');
            return FALSE;
        }
    }

    function xt_unique_email() {
        $xtWhere = "";
        if (isset($_GET['id'])) {
            $xtWhere .= " AND xtUserID != " . base64_decode($_GET['id']);
        }
        $xtUserEmail = $_POST['xtUserEmail'];
        $xtRecordsWithSameEmail = $this->common_model->get_row("xt_user", "xtUserEmail", $xtUserEmail, $xtWhere);
        if ($xtRecordsWithSameEmail) {
            $this->form_validation->set_message('xt_unique_email', '%s should be unique.');
            return FALSE;
        }
        return true;
    }

}
