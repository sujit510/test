<?php echo $ncPageTitle . "<br>"; ?>

<?php echo form_button("ncAdd", "Back To List", " onclick=\"window.location.href='" . SITEADMINURL . "/user/list_user'\"") ?>
<?php echo form_open_multipart($ncFormAction) ?>
<?php if($ncErrors != "") echo $ncErrors ?>
<!--Display headers-->
<table id="list_table">
        
    <tr>
        <td><?php echo form_label("First Name : "); ?></td>
        <td><?php echo form_input("ncUserFirstName", $ncUserFirstName); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Last Name : "); ?></td>
        <td><?php echo form_input("ncUserLastName", $ncUserLastName); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Contact Number : "); ?></td>
        <td><?php echo form_input("ncUserContactNumber", $ncUserContactNumber); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Role : "); ?></td>
        <td><?php echo form_multiselect("ncUserRole[]", $ncRolesArray, $ncUserRole); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Email : "); ?></td>
        <td><?php echo form_input("ncUserEmail", $ncUserEmail); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Password : "); ?></td>
        <td><?php echo form_password("ncUserPassword", ""); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Confirm Password : "); ?></td>
        <td><?php echo form_password("ncUserConfirmPassword", ""); ?></td>
    </tr>
    <tr>
        <td><?php echo form_submit("ncSubmit", "Submit"); ?></td>
        <td><?php echo form_reset("ncReset", "Reset"); ?></td>
    </tr>
<?php echo form_hidden("ncPageAction", $ncPageAction); ?>    
    <?php echo form_close(); ?>    
</table>
