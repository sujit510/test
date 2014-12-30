<?php echo $ncPageTitle . "<br>"; ?>

<?php echo form_button("ncAdd", "Back To List", " onclick=\"window.location.href='" . SITEADMINURL . "/webservice_log/list_webservice_log'\"") ?>
<?php echo form_open_multipart($ncFormAction) ?>
<?php if($ncErrors != "") echo $ncErrors ?>
<!--Display headers-->
<table id="log_table">
    <tr>
        <td><?php echo "Request : " ?></td>
        <td><pre><?php echo $ncWebserviceLogRecord[0]->Request ?></pre></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo "Response : " ?></td>
        <td><pre><?php echo $ncWebserviceLogRecord[1]->Response ?></pre></td>
    </tr>
</table>