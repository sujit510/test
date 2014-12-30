<?php

$config = array(
    'register' => array(
        array(
            'field' => 'ncUserFirstName',
            'label' => 'First Name',
            'rules' => 'required'
        ),
        array(
            'field' => 'ncUserLastName',
            'label' => 'Last Name',
            'rules' => 'required'
        ),
        array(
            'field' => 'ncUserContactNumber',
            'label' => 'Contact Number',
            'rules' => 'required|numeric|exact_length[10]'
        ),
        array(
            'field' => 'ncUserRole',
            'label' => 'Role',
            'rules' => 'required'
        ),
        array(
            'field' => 'ncUserEmail',
            'label' => 'Email',
            'rules' => 'required|valid_email|callback_xt_unique_email'
        ),
        array(
            'field' => 'ncUserPassword',
            'label' => 'Password',
            'rules' => 'required'
        ),
        array(
            'field' => 'ncUserConfirmPassword',
            'label' => 'Confirm Password',
            'rules' => 'required|callback_xt_match_passwords'
        ),
    ),
);
