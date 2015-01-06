<?php echo $xtPageTitle . "<br>"; ?>

<?php echo form_button("xtAdd", "Back To List", " onclick=\"window.location.href='" . SITEURL . "/webservice_log/list_webservice_log'\"") ?>
<?php echo form_open_multipart($xtFormAction) ?>
<?php if($xtErrors != "") echo $xtErrors ?>
<!--Display headers-->
<table id="log_table">
    <tr>
        <td><?php echo "Request : " ?></td>
        <td><pre><?php echo $xtWebserviceLogRecord[0]->xtRequest ?></pre></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo "Response : " ?></td>
        <td><pre><?php echo $xtWebserviceLogRecord[1]->xtResponse ?></pre></td>
    </tr>
</table>