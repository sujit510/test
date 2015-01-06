<?php echo $xtPageTitle . "<br>"; ?>

<?php echo form_button("xtAdd", "Back To List", " onclick=\"window.location.href='" . SITEURL . "/user/list_user'\"") ?>
<?php echo form_open_multipart($xtFormAction) ?>
<?php if($xtErrors != "") echo $xtErrors ?>
<!--Display headers-->
<table id="list_table">
        
    <tr>
        <td><?php echo form_label("First Name : "); ?></td>
        <td><?php echo form_input("xtUserFirstName", $xtUserFirstName); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Last Name : "); ?></td>
        <td><?php echo form_input("xtUserLastName", $xtUserLastName); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Contact Number : "); ?></td>
        <td><?php echo form_input("xtUserContactNumber", $xtUserContactNumber); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Role : "); ?></td>
        <td><?php echo form_dropdown("xtUserRole", $xtRolesArray, $xtUserRole); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Email : "); ?></td>
        <td><?php echo form_input("xtUserEmail", $xtUserEmail); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Password : "); ?></td>
        <td><?php echo form_password("xtUserPassword", ""); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label("Confirm Password : "); ?></td>
        <td><?php echo form_password("xtUserConfirmPassword", ""); ?></td>
    </tr>
    <tr>
        <td><?php echo form_submit("xtSubmit", "Submit"); ?></td>
        <td><?php echo form_reset("xtReset", "Reset"); ?></td>
    </tr>
<?php echo form_hidden("xtPageAction", $xtPageAction); ?>    
    <?php echo form_close(); ?>    
</table>
